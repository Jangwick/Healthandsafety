<div class="row" style="max-width: 900px; margin: 0 auto;">
    <div class="col-12">
        <form action="/inspections/process" method="POST">
            <input type="hidden" name="inspection_id" value="<?= $inspection['id'] ?>">
            
            <!-- Header Info -->
            <div class="card shadow-sm mb-4" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1); margin-bottom: 2rem;">
                <div class="card-body" style="padding: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2 style="margin: 0; font-size: 1.5rem; font-weight: 800; color: var(--text-color-1);"><?= htmlspecialchars($inspection['business_name']) ?></h2>
                        <div style="display: flex; gap: 1rem; margin-top: 0.5rem; font-size: 0.875rem; color: var(--text-secondary-1);">
                            <span><i class="fas fa-file-invoice"></i> <?= htmlspecialchars($inspection['template_name']) ?></span>
                            <span><i class="fas fa-calendar-alt"></i> Scheduled: <?= date('M d, Y', strtotime($inspection['scheduled_date'])) ?></span>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <span class="priority-badge priority-<?= strtolower($inspection['priority']) ?>" style="font-size: 0.75rem; padding: 0.4rem 0.8rem; border-radius: 4px; font-weight: 700;">
                            <?= $inspection['priority'] ?> PRIORITY
                        </span>
                    </div>
                </div>
            </div>

            <!-- Checklist -->
            <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
                <div class="card-header" style="background: rgba(0,0,0,0.02); border-bottom: 1px solid var(--border-color-1); padding: 1.25rem 1.5rem;">
                    <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: var(--text-color-1);">Compliance Checklist</h3>
                    <p style="margin: 0.25rem 0 0; font-size: 0.875rem; color: var(--text-secondary-1);">Mark each item based on current field observations</p>
                </div>
                <div class="card-body" style="padding: 0;">
                    <?php if (empty($items)): ?>
                        <div style="padding: 3rem; text-align: center; color: var(--text-secondary-1);">
                            No checklist items found for this category.
                        </div>
                    <?php else: ?>
                        <div class="checklist-container">
                            <?php foreach ($items as $index => $item): ?>
                                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color-1); display: flex; align-items: flex-start; gap: 1.5rem; transition: background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.01)'" onmouseout="this.style.background='transparent'">
                                    <div style="font-weight: 700; color: var(--primary-color-1); font-size: 1.1rem; min-width: 25px;">
                                        <?= $index + 1 ?>.
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-weight: 600; font-size: 1rem; color: var(--text-color-1); margin-bottom: 0.25rem;">
                                            <?= htmlspecialchars($item['text'] ?? ($item['description'] ?? 'Requirement')) ?>
                                        </div>
                                        <p style="margin: 0; font-size: 0.85rem; color: var(--text-secondary-1);">
                                            Verify compliance with standard safety protocols and local ordinances.
                                        </p>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <!-- Pass Button (Radio Style) -->
                                        <label style="cursor: pointer;">
                                            <input type="radio" name="items[<?= $item['id'] ?>]" value="1" required style="display: none;" class="check-input">
                                            <div class="check-button pass" style="padding: 0.6rem 1rem; border: 1px solid #e2e8f0; border-radius: 8px; font-weight: 700; font-size: 0.8rem; display: flex; align-items: center; gap: 0.4rem; transition: all 0.2s;">
                                                <i class="fas fa-check"></i> PASS
                                            </div>
                                        </label>
                                        <!-- Fail Button (Radio Style) -->
                                        <label style="cursor: pointer;">
                                            <input type="radio" name="items[<?= $item['id'] ?>]" value="0" required style="display: none;" class="check-input">
                                            <div class="check-button fail" style="padding: 0.6rem 1rem; border: 1px solid #e2e8f0; border-radius: 8px; font-weight: 700; font-size: 0.8rem; display: flex; align-items: center; gap: 0.4rem; transition: all 0.2s;">
                                                <i class="fas fa-times"></i> FAIL
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Remarks Area -->
                    <div style="padding: 2rem; background: rgba(0,0,0,0.02);">
                        <label style="display: block; font-weight: 700; font-size: 0.9rem; margin-bottom: 0.75rem; color: var(--text-color-1);">General Remarks / Findings</label>
                        <textarea name="remarks" rows="4" style="width: 100%; padding: 1rem; border: 1px solid var(--border-color-1); border-radius: 10px; background: white; font-size: 0.95rem;" placeholder="Enter any additional observations, violations, or recommendations..."></textarea>
                    </div>
                </div>
                <div class="card-footer" style="padding: 1.5rem; background: white; border-top: 1px solid var(--border-color-1); display: flex; justify-content: space-between; align-items: center;">
                    <a href="/inspections" style="color: var(--text-secondary-1); text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                    <button type="submit" class="btn btn-success" style="padding: 0.8rem 2.5rem; border-radius: 10px; font-weight: 800; font-size: 1rem; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);">
                        SUBMIT INSPECTION
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.check-input:checked + .check-button.pass {
    background: #10b981;
    color: white;
    border-color: #10b981;
    box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
}
.check-input:checked + .check-button.fail {
    background: #ef4444;
    color: white;
    border-color: #ef4444;
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
}
.check-button:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
}
</style>
