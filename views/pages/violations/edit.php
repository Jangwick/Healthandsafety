<div class="card shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1); max-width: 800px; margin: 0 auto;">
    <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.5rem;">
        <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600; color: var(--text-color-1);">
            <i class="fas fa-edit text-primary" style="margin-right: 0.5rem;"></i>Edit Violation Record
        </h3>
    </div>
    <div class="card-body" style="padding: 2rem;">
        <form action="/violations/update" method="POST">
            <input type="hidden" name="id" value="<?= $violation['id'] ?>">
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--text-color-1); margin-bottom: 0.5rem;">Establishment</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($violation['establishment_name']) ?>" readonly style="background: var(--bg-color-2);">
                <small style="color: var(--text-secondary-1); margin-top: 0.25rem; display: block;">Linked inspection cannot be changed.</small>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--text-color-1); margin-bottom: 0.5rem;">Violation Description</label>
                <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($violation['description']) ?></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--text-color-1); margin-bottom: 0.5rem;">Fine Amount (PHP)</label>
                    <input type="number" name="fine_amount" class="form-control" step="0.01" value="<?= $violation['fine_amount'] ?>" required>
                </div>
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--text-color-1); margin-bottom: 0.5rem;">Due Date</label>
                    <input type="date" name="due_date" class="form-control" value="<?= $violation['due_date'] ? date('Y-m-d', strtotime($violation['due_date'])) : '' ?>">
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--text-color-1); margin-bottom: 0.5rem;">Current Status</label>
                <select name="status" class="form-control">
                    <option value="Pending" <?= $violation['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="In Progress" <?= $violation['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                    <option value="Paid" <?= $violation['status'] === 'Paid' ? 'selected' : '' ?>>Paid</option>
                    <option value="Resolved" <?= $violation['status'] === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                </select>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color-1); padding-top: 1.5rem;">
                <button type="button" onclick="if(confirm('Are you sure you want to delete this violation record? This cannot be undone.')) window.location.href='/violations/delete?id=<?= $violation['id'] ?>'" class="btn btn-outline-danger" style="color: #ef4444; border-color: #ef4444; padding: 0.75rem 1.5rem; border-radius: 8px;">
                    <i class="fas fa-trash"></i> Delete Record
                </button>
                <div style="display: flex; gap: 1rem;">
                    <a href="/violations/show?id=<?= $violation['id'] ?>" class="btn btn-outline-secondary" style="text-decoration: none; display: flex; align-items: center; padding: 0.75rem 1.5rem; border-radius: 8px;">Cancel</a>
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; border-radius: 8px; font-weight: 600;">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>