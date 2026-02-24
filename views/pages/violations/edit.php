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
    .modern-input:read-only {
        background: rgba(0,0,0,0.02);
        color: var(--text-secondary-1);
        cursor: not-allowed;
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
            <div style="padding: 2.5rem; background: linear-gradient(to bottom right, rgba(239, 68, 68, 0.05), transparent); border-bottom: 1px solid var(--border-color-1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2 style="margin: 0; font-weight: 800; font-size: 1.5rem; color: var(--text-color-1);">Edit Violation Citation</h2>
                        <p style="margin: 0.5rem 0 0; color: var(--text-secondary-1); font-size: 0.9rem;">Regulatory enforcement record for <strong><?= htmlspecialchars($violation['establishment_name']) ?></strong></p>
                    </div>
                </div>
            </div>

            <!-- Form Body -->
            <div style="padding: 2.5rem;">
                <form action="/violations/update" method="POST">
                    <input type="hidden" name="id" value="<?= $violation['id'] ?>">

                    <div class="form-section-title">
                        <i class="fas fa-exclamation-triangle"></i> Citation Details
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <label class="custom-label">Associated Establishment</label>
                            <input type="text" class="modern-input" value="<?= htmlspecialchars($violation['establishment_name']) ?>" readonly>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="custom-label">Infraction Description / Specific Violations</label>
                            <textarea name="description" class="modern-input" rows="4" required placeholder="Describe the health or safety violations found during inspection..."><?= htmlspecialchars($violation['description']) ?></textarea>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="custom-label">Penalized Fine Amount (PHP)</label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); font-weight: 700; color: var(--text-secondary-1);">₱</span>
                                <input type="number" name="fine_amount" class="modern-input" style="padding-left: 2rem;" step="0.01" value="<?= $violation['fine_amount'] ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="custom-label">Settlement Deadline (Due Date)</label>
                            <input type="date" name="due_date" class="modern-input" value="<?= $violation['due_date'] ? date('Y-m-d', strtotime($violation['due_date'])) : '' ?>">
                        </div>

                        <div class="col-md-12">
                            <label class="custom-label">Enforcement Status</label>
                            <select name="status" class="modern-input">
                                <option value="Pending" <?= $violation['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="In Progress" <?= $violation['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                <option value="Paid" <?= $violation['status'] === 'Paid' ? 'selected' : '' ?>>Paid</option>
                                <option value="Resolved" <?= $violation['status'] === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                            </select>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="margin-top: 3.5rem; display: flex; justify-content: space-between; align-items: center;">
                        <button type="button" 
                                onclick="if(confirm('Caution: This will permanently delete the violation record. Proceed?')) window.location.href='/violations/delete?id=<?= $violation['id'] ?>'" 
                                class="btn text-danger" style="font-weight: 700; font-size: 0.85rem;">
                            <i class="fas fa-trash me-2"></i> Delete Citation
                        </button>
                        
                        <div style="display: flex; align-items: center; gap: 1.5rem;">
                            <a href="/violations/show?id=<?= $violation['id'] ?>" style="text-decoration: none; font-weight: 700; color: var(--text-secondary-1); font-size: 0.9rem;">Discard Changes</a>
                            <button type="submit" class="btn-save">
                                <i class="fas fa-check-circle me-2"></i> Update Record
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
