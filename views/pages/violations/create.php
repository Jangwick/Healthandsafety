<div class="card shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1); max-width: 800px; margin: 0 auto;">
    <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.5rem;">
        <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600; color: var(--text-color-1);">
            <i class="fas fa-plus-circle text-primary" style="margin-right: 0.5rem;"></i>New Violation Record
        </h3>
    </div>
    <div class="card-body" style="padding: 2rem;">
        <form action="/violations/store" method="POST">
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--text-color-1); margin-bottom: 0.5rem;">Linked Inspection</label>
                <select name="inspection_id" class="form-control" required>
                    <option value="">Select an inspection...</option>
                    <?php foreach ($inspections as $inspection): ?>
                        <option value="<?= $inspection['id'] ?>">
                            #<?= $inspection['id'] ?> - <?= htmlspecialchars($inspection['establishment_name'] ?? 'Unknown Est.') ?> (<?= date('M d, Y', strtotime($inspection['scheduled_date'])) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <small style="color: var(--text-secondary-1); margin-top: 0.25rem; display: block;">Violations must be linked to an inspection record.</small>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--text-color-1); margin-bottom: 0.5rem;">Violation Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Describe the violation in detail..." required></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--text-color-1); margin-bottom: 0.5rem;">Fine Amount (PHP)</label>
                    <input type="number" name="fine_amount" class="form-control" step="0.01" value="0.00" required>
                </div>
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--text-color-1); margin-bottom: 0.5rem;">Due Date</label>
                    <input type="date" name="due_date" class="form-control" value="<?= date('Y-m-d', strtotime('+7 days')) ?>">
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--text-color-1); margin-bottom: 0.5rem;">Initial Status</label>
                <select name="status" class="form-control">
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Paid">Paid</option>
                    <option value="Resolved">Resolved</option>
                </select>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; border-top: 1px solid var(--border-color-1); padding-top: 1.5rem;">
                <a href="/violations" class="btn btn-outline-secondary" style="text-decoration: none; display: flex; align-items: center; padding: 0.75rem 1.5rem; border-radius: 8px;">Cancel</a>
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; border-radius: 8px; font-weight: 600;">Record Violation</button>
            </div>
        </form>
    </div>
</div>