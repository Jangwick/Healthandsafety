# Feature Implementation Plan: Inspector Checklist & File Upload

## Objective
Enable inspectors to manage inspection checklists more effectively by allowing them to download/edit the checklist during an inspection, and providing the capability to upload supporting files (images, documents) directly to the inspection record.

## 1. Database Modifications
We need to track uploaded files and potentially allow checklist modifications. The existing \`inspection_items\` table handles individual checklist items and already has a \`photo_path\` column. We need a way to store general inspection files and track if an inspector modified the original template checklist for a specific inspection.

### 1.1 Store Inspection Files
Create a new migration (e.g., \`13_CreateInspectionFilesTable.php\`) to create an \`inspection_files\` table:
- \`id\` (INT, Primary Key)
- \`inspection_id\` (INT, Foreign Key referencing \`inspections.id\`)
- \`file_name\` (VARCHAR 255)
- \`file_path\` (VARCHAR 255)
- \`file_type\` (VARCHAR 50)
- \`file_size\` (INT)
- \`uploaded_by\` (INT, Foreign Key referencing \`users.id\`)
- \`created_at\` (TIMESTAMP)

### 1.2 Customizing Inspection Checklists
If "editing the checklist" means the inspector can add/remove items specific to *this* inspection (deviating from the base \`template_id\`), we need to store a localized JSON copy of the checklist on the \`inspections\` table itself.
- Add \`custom_checklist_json\` (LONGTEXT) to \`inspections\`.
- When an inspection is created, it inherits from the template. If edited, the modified JSON is saved here.

## 2. Backend Architecture (Controllers & Services)

### 2.1 File Upload Handling (InspectionController.php)
Create endpoints to handle file uploads for an inspection:
- **Route**: \`POST /inspections/upload-file\`
- **Logic**: 
  - Validate file type (image/png, image/jpeg, application/pdf, etc.) and size.
  - Move file to \`uploads/inspections/[inspection_id]/\`.
  - Insert record into \`inspection_files\` table.
- **Route**: \`DELETE /inspections/delete-file\` (allows removal of accidentally uploaded files).

### 2.2 Download Checklist (InspectionController.php)
Create an endpoint to generate a downloadable version of the checklist (PDF or CSV):
- **Route**: \`GET /inspections/download-checklist?id=[id]\`
- **Logic**: Fetch the inspection details and its associated checklist items. Use a PDF library (like Dompdf) or native CSV generation to stream the file to the user's browser.

### 2.3 Edit Checklist Definitions
If inspectors can edit the checklist structure during an active inspection:
- **Route**: \`POST /inspections/update-checklist\`
- **Logic**: Receive the updated JSON array of items from the frontend and save it to the \`custom_checklist_json\` column in the \`inspections\` table.

## 3. Frontend Implementation (Views & JavaScript)

### 3.1 Inspection Interface Updates (\`views/pages/inspections/conduct.php\`)
The interface where the inspector conducts the inspection needs to be augmented:

#### A. Download Button
- Add a "Download Checklist" button near the top of the interface.
- Clicking it triggers a download of the blank or currently filled checklist.

#### B. Edit Checklist Feature
- Add an "Edit Checklist Items" toggle/button.
- When activated, allow the inspector to:
  - Add new custom checklist items.
  - Remove irrelevant items.
  - Change weights of items.
- Provide a "Save Custom Checklist" button that sends the AJAX request to \`update-checklist\`.

#### C. File Upload Section
- Create a dedicated "Supporting Documents & Evidence" section below the checklist items.
- Implement a Drag-and-Drop file uploader (or standard \`<input type="file" multiple>\`).
- Use AJAX to upload files immediately upon selection.
- Display a list/grid of successfully uploaded files with thumbnails (for images) and a delete button for each.

## 4. Security & Validation
- **Authentication**: Ensure all new routes use \`AuthMiddleware\`.
- **Authorization**: Verify the user uploading the file or editing the checklist is the assigned \`inspector_id\` for that specific inspection, or an Admin.
- **File Validation**: Strictly validate MIME types and file extensions on the server side to prevent malicious uploads (e.g., block .php, .exe, .sh files). Limit file size (e.g., 5MB per file).
- **Path Traversal**: Ensure file names are sanitized before saving to disk to prevent path traversal attacks.

## 5. Phased Rollout Plan
1. **Phase 1: File Uploads.** Implement the database table, backend upload logic, and the frontend upload component on the "Conduct Inspection" page.
2. **Phase 2: Checklist Downloading.** Implement the PDF/CSV generation logic and add the download button to the UI.
3. **Phase 3: Checklist Editing.** If required, implement the \`custom_checklist_json\` logic, update the frontend to allow dynamic layout changes, and ensure scoring calculations properly utilize the customized checklist.
