<div class="row justify-content-center">
    <div class="col-8">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
            <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.5rem;">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-color-1);">System Configuration</h3>
                <p style="margin: 0.25rem 0 0; font-size: 0.875rem; color: var(--text-secondary-1);">Configure global parameters for LGU Health and Safety operations</p>
            </div>
            
            <div class="card-body" style="padding: 2rem;">
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success d-flex align-items-center mb-4" style="border-radius: 8px; border: none; background: rgba(25, 135, 84, 0.1); color: #198754;">
                        <i class="fas fa-check-circle me-2"></i>
                        Settings have been successfully updated.
                    </div>
                <?php endif; ?>

                <form action="/settings/update" method="POST">
                    <div class="row">
                        <!-- LGU Metadata -->
                        <div class="col-12 mb-4">
                            <h5 style="font-size: 1rem; font-weight: 700; color: var(--text-color-1); padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-color-1); margin-bottom: 1.5rem;">
                                Organization Information
                            </h5>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">LGU Name</label>
                            <input type="text" name="settings[lgu_name]" value="<?= htmlspecialchars($settings['lgu_name'] ?? '') ?>" required
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1);">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">Operating Office</label>
                            <input type="text" name="settings[office_name]" value="<?= htmlspecialchars($settings['office_name'] ?? '') ?>" required
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1);">
                        </div>

                        <!-- Compliance Parameters -->
                        <div class="col-12 mb-4 mt-2">
                            <h5 style="font-size: 1rem; font-weight: 700; color: var(--text-color-1); padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-color-1); margin-bottom: 1.5rem;">
                                Compliance & Penalty Logic
                            </h5>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">Default Violation Fine (PHP)</label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1); font-weight: 600;">₱</span>
                                <input type="number" step="0.01" name="settings[penalty_amount]" value="<?= htmlspecialchars($settings['penalty_amount'] ?? '') ?>" required
                                    style="width: 100%; padding: 0.75rem 1rem 0.75rem 2rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1);">
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">Certificate Validity (Years)</label>
                            <div style="position: relative;">
                                <i class="fas fa-calendar-alt" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1);"></i>
                                <input type="number" name="settings[permit_validity_years]" value="<?= htmlspecialchars($settings['permit_validity_years'] ?? '') ?>" required
                                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1);">
                            </div>
                        </div>

                        <div class="col-12 mb-4">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">System Display Title</label>
                            <input type="text" name="settings[system_title]" value="<?= htmlspecialchars($settings['system_title'] ?? '') ?>" required
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1);">
                        </div>
                    </div>

                    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color-1); display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn btn-primary" style="background: var(--primary-color-1); border: none; padding: 0.8rem 2.5rem; border-radius: 8px; font-weight: 700; color: white;">
                            <i class="fas fa-save" style="margin-right: 0.5rem;"></i> Save Configuration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>