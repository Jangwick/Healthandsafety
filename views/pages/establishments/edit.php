<?php
$contact = json_decode($establishment['contact_json'] ?? '{}', true);
?>

<style>
    .edit-card {
        border-radius: 20px;
        border: 1px solid var(--border-color-1);
        background: var(--card-bg-1);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .form-section-title {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--primary-color-1);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .form-section-title::after {
        content: "";
        flex: 1;
        height: 1px;
        background: var(--border-color-1);
    }
    .custom-input-group {
        margin-bottom: 1.5rem;
    }
    .custom-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-secondary-1);
        margin-bottom: 0.5rem;
        display: block;
    }
    .modern-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        border: 1.5px solid var(--border-color-1);
        background: var(--header-bg-1);
        color: var(--text-color-1);
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }
    .modern-input:focus {
        outline: none;
        border-color: var(--primary-color-1);
        box-shadow: 0 0 0 4px rgba(var(--primary-color-1-rgb, 76, 138, 137), 0.1);
    }
    .btn-save {
        background: var(--primary-color-1);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(var(--primary-color-1-rgb, 76, 138, 137), 0.2);
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(var(--primary-color-1-rgb, 76, 138, 137), 0.3);
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="edit-card">
            <!-- Header Section -->
            <div style="padding: 2.5rem; background: linear-gradient(to bottom right, rgba(var(--primary-color-1-rgb, 76, 138, 137), 0.05), transparent); border-bottom: 1px solid var(--border-color-1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2 style="margin: 0; font-weight: 800; font-size: 1.5rem; color: var(--text-color-1);">Update Establishment</h2>
                        <p style="margin: 0.5rem 0 0; color: var(--text-secondary-1); font-size: 0.9rem;">Modify regulatory data for <strong><?= htmlspecialchars($establishment['name']) ?></strong></p>
                    </div>
                    <a href="/establishments/delete?id=<?= $establishment['id'] ?>" 
                       class="btn text-danger bg-danger-subtle" 
                       style="padding: 0.6rem 1rem; border-radius: 10px; font-weight: 700; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem; border: 1px solid rgba(220, 38, 38, 0.1);"
                       onclick="return confirm('Note: This action will mark the establishment as inactive. Proceed?')">
                        <i class="fas fa-trash-alt"></i> Archive Record
                    </a>
                </div>
            </div>

            <!-- Form Body -->
            <div style="padding: 2.5rem;">
                <form action="/establishments/update" method="POST">
                    <input type="hidden" name="id" value="<?= $establishment['id'] ?>">

                    <!-- Genral Info Section -->
                    <div class="form-section-title">
                        <i class="fas fa-info-circle"></i> General Information
                    </div>
                    
                    <div class="row custom-input-group">
                        <div class="col-md-12 mb-3">
                            <label class="custom-label">Official Business Name</label>
                            <input type="text" name="name" class="modern-input" value="<?= htmlspecialchars($establishment['name']) ?>" placeholder="e.g. Industrial Storage Solutions" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="custom-label">Establishment Category</label>
                            <select name="type" class="modern-input" required>
                                <option value="Restaurant/Cafe" <?= $establishment['type'] === 'Restaurant/Cafe' ? 'selected' : '' ?>>Restaurant/Cafe</option>
                                <option value="Accommodation" <?= $establishment['type'] === 'Accommodation' ? 'selected' : '' ?>>Accommodation</option>
                                <option value="Commercial" <?= $establishment['type'] === 'Commercial' ? 'selected' : '' ?>>Commercial</option>
                                <option value="Industrial" <?= $establishment['type'] === 'Industrial' ? 'selected' : '' ?>>Industrial</option>
                                <option value="Warehouse" <?= $establishment['type'] === 'Warehouse' ? 'selected' : '' ?>>Warehouse</option>
                                <option value="Other" <?= $establishment['type'] === 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="custom-label">Compliance Status</label>
                            <select name="status" class="modern-input" required>
                                <option value="Active" <?= $establishment['status'] === 'Active' ? 'selected' : '' ?>>Active</option>
                                <option value="Suspended" <?= $establishment['status'] === 'Suspended' ? 'selected' : '' ?>>Suspended</option>
                                <option value="Closed" <?= $establishment['status'] === 'Closed' ? 'selected' : '' ?>>Closed</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="custom-label">Site Address & Coordinates</label>
                            <textarea name="location" class="modern-input" rows="3" placeholder="Enter complete physical address..." required><?= htmlspecialchars($establishment['location']) ?></textarea>
                        </div>
                    </div>

                    <!-- Contact Details Section -->
                    <div class="form-section-title" style="margin-top: 2rem;">
                        <i class="fas fa-id-card"></i> Contact & Stakeholders
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="custom-label">Authorized Representative / Owner</label>
                            <div style="position: relative;">
                                <i class="fas fa-user" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1); font-size: 0.8rem;"></i>
                                <input type="text" name="owner" class="modern-input" style="padding-left: 2.5rem;" value="<?= htmlspecialchars($contact['owner'] ?? '') ?>" placeholder="Full Name">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="custom-label">Business Email</label>
                            <div style="position: relative;">
                                <i class="fas fa-envelope" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1); font-size: 0.8rem;"></i>
                                <input type="email" name="email" class="modern-input" style="padding-left: 2.5rem;" value="<?= htmlspecialchars($contact['email'] ?? '') ?>" placeholder="contact@example.com">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="custom-label">Primary Contact Number</label>
                            <div style="position: relative;">
                                <i class="fas fa-phone" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1); font-size: 0.8rem;"></i>
                                <input type="text" name="phone" class="modern-input" style="padding-left: 2.5rem;" value="<?= htmlspecialchars($contact['phone'] ?? '') ?>" placeholder="+63 9xx xxx xxxx">
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="margin-top: 3rem; pt-3; display: flex; justify-content: flex-end; align-items: center; gap: 1rem;">
                        <a href="/establishments" style="text-decoration: none; font-weight: 700; color: var(--text-secondary-1); font-size: 0.95rem; margin-right: 1rem;">Cancel</a>
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save me-2"></i> Commit Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
