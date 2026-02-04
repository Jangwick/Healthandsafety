<?php
$contact = json_decode($establishment['contact_json'] ?? '{}', true);
?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
            <div class="card-header border-bottom" style="background: transparent; padding: 1.5rem;">
                <h5 class="mb-0 text-white" style="font-weight: 700;">Update Establishment Information</h5>
                <p class="text-secondary small mb-0">Modify details for <?= htmlspecialchars($establishment['name']) ?></p>
            </div>
            <div class="card-body p-4">
                <form action="/establishments/update" method="POST">
                    <input type="hidden" name="id" value="<?= $establishment['id'] ?>">
                    
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label text-secondary small fw-bold">Business Name</label>
                            <input type="text" name="name" class="form-control bg-dark border-secondary text-white" value="<?= htmlspecialchars($establishment['name']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-secondary small fw-bold">Establishment Type</label>
                            <select name="type" class="form-select bg-dark border-secondary text-white" required>
                                <option value="Restaurant/Cafe" <?= $establishment['type'] === 'Restaurant/Cafe' ? 'selected' : '' ?>>Restaurant/Cafe</option>
                                <option value="Accommodation" <?= $establishment['type'] === 'Accommodation' ? 'selected' : '' ?>>Accommodation</option>
                                <option value="Commercial" <?= $establishment['type'] === 'Commercial' ? 'selected' : '' ?>>Commercial</option>
                                <option value="Industrial" <?= $establishment['type'] === 'Industrial' ? 'selected' : '' ?>>Industrial</option>
                                <option value="Warehouse" <?= $establishment['type'] === 'Warehouse' ? 'selected' : '' ?>>Warehouse</option>
                                <option value="Other" <?= $establishment['type'] === 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-secondary small fw-bold">Registration Status</label>
                            <select name="status" class="form-select bg-dark border-secondary text-white" required>
                                <option value="Active" <?= $establishment['status'] === 'Active' ? 'selected' : '' ?>>Active</option>
                                <option value="Suspended" <?= $establishment['status'] === 'Suspended' ? 'selected' : '' ?>>Suspended</option>
                                <option value="Closed" <?= $establishment['status'] === 'Closed' ? 'selected' : '' ?>>Closed</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label text-secondary small fw-bold">Full Address / Location</label>
                            <textarea name="location" class="form-control bg-dark border-secondary text-white" rows="2" required><?= htmlspecialchars($establishment['location']) ?></textarea>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Owner/Manager</label>
                            <input type="text" name="owner" class="form-control bg-dark border-secondary text-white" value="<?= htmlspecialchars($contact['owner'] ?? '') ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Contact Number</label>
                            <input type="text" name="phone" class="form-control bg-dark border-secondary text-white" value="<?= htmlspecialchars($contact['phone'] ?? '') ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-secondary small fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control bg-dark border-secondary text-white" value="<?= htmlspecialchars($contact['email'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top border-secondary d-flex justify-content-between">
                        <a href="/establishments/delete?id=<?= $establishment['id'] ?>" class="btn btn-outline-danger" onclick="return confirm('Archive this establishment?')">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </a>
                        <div class="btn-group gap-2">
                            <a href="/establishments" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>