# Implementation Plan: Admin Violation & Inspection Enhancements

## 1. Refined User Requirements (Prompt)
"Develop an Admin-centric Violation Management System to streamline the transition from failed inspections to legal compliance."

*   **Admin Violation Portal**: A dedicated interface for administrators to review all violations triggered by failed inspections.
*   **Integrated Evidence**: Direct visibility of captured photos and inspector remarks within the violation record.
*   **Fine Assignment Workflow**: A streamlined process for admins to analyze descriptions and issues to assign appropriate fine amounts and due dates.
*   **Enhanced Inspection Flow**: Seamless photo uploading during the audit process that flows into the evidence trail.

---

## 2. Technical Strategy

### A. Data Layer
*   **Table: `inspection_items`**: Verify the `photo_path` column is active (already implemented).
*   **Table: `violations`**: Ensure `fine_amount`, `description`, and `due_date` columns are used for the assignment workflow.
*   **Table: `inspections`**: Use the `remarks` column to provide context for the admin.

### B. Controller Logic (`ViolationController`)
*   **`show($id)`**: Enhance to fetch not just failed items, but their associated `photo_path` and `notes`.
*   **`assignFine()`**: (New) A dedicated POST route to update fine amounts and due dates specifically, with audit logging.

### C. UI/UX Enhancements (Views)
1.  **Inspection Conduct (`conduct.php`)**: (Done) Already supports per-item photo uploads.
2.  **Violation List (`list.php`)**:
    *   Add a "New / Needs Fine" badge for violations with a $0 fine or newly generated.
    *   Filter by "Awaiting Assignment".
3.  **Violation Detail (`show.php`)**:
    *   **Evidence Gallery**: Add a section or column in the "Deficiencies" table to display thumbnails of the proof photos captured by the inspector.
    *   **Quick Fine UI**: If the user is an Admin and the fine is not yet assigned/finalized, show a prominent "Assign Penalty" card.
4.  **Violation Adjustment (`edit.php`)**:
    *   Refine as a "Penalty Assignment" form.

---

## 3. Implementation Steps

### Phase 1: Evidence Integration
*   Modify `ViolationController@show` to include `photo_path` in the `failedItems` query.
*   Update `views/pages/violations/show.php` to display these photos in the "Identified Deficiencies" table.

### Phase 2: Admin Dashboard Refinement
*   Update `ViolationController@index` to include a status count for "Awaiting Assignment".
*   Enhance `views/pages/violations/list.php` table to show a distinct visual style for new violations that haven't been reviewed by an admin yet.

### Phase 3: Fine Assignment Workflow
*   Create a "Quick Assign" form in the Violation Detail view for Admins.
*   Implement the backend logic to update the violation and log the action in the Audit History.

### Phase 4: Final Polish & Testing
*   Verify that photos uploaded on mobile devices (inspectors in the field) correctly display in the Admin's desktop view.
*   Test the automatic generation of citations after the fine is assigned.
