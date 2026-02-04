<div class="row justify-content-center">
    <div class="col-8">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
            <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-color-1);">System User Registration</h3>
                    <p style="margin: 0.25rem 0 0; font-size: 0.875rem; color: var(--text-secondary-1);">Create a new access account for LGU personnel</p>
                </div>
                <a href="/users" class="btn btn-secondary" style="background: rgba(0,0,0,0.05); color: var(--text-color-1); border: none; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 600;">
                    Cancel
                </a>
            </div>
            
            <div class="card-body" style="padding: 2rem;">
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger d-flex align-items-center mb-4" style="border-radius: 8px; border: none; background: rgba(220, 53, 69, 0.1); color: #dc3545;">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php endif; ?>

                <form action="/users/store" method="POST">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">Full Legal Name</label>
                            <div style="position: relative;">
                                <i class="fas fa-user-tag" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1);"></i>
                                <input type="text" name="full_name" required placeholder="e.g. John Albert Doe" 
                                    style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1);">
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">Official Email Address</label>
                            <div style="position: relative;">
                                <i class="fas fa-envelope" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1);"></i>
                                <input type="email" name="email" required placeholder="name@lgu.gov.ph" 
                                    style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1);">
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">System Access Role</label>
                            <div style="position: relative;">
                                <i class="fas fa-user-shield" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1);"></i>
                                <select name="role_id" required 
                                    style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1); appearance: none;">
                                    <option value="">Select Role...</option>
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?= $role['id'] ?>"><?= htmlspecialchars($role['name']) ?> (Hierarchy Level: <?= $role['hierarchy_level'] ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">Initial Account Password</label>
                            <div style="position: relative;">
                                <i class="fas fa-lock" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1);"></i>
                                <input type="password" name="password" required 
                                    style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1);">
                            </div>
                            <p style="margin: 0.5rem 0 0; font-size: 0.75rem; color: var(--text-secondary-1);">System requirement: Minimum 8 characters recommended.</p>
                        </div>
                    </div>

                    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color-1); display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn btn-primary" style="background: var(--primary-color-1); border: none; padding: 0.8rem 2.5rem; border-radius: 8px; font-weight: 700; color: white;">
                            <i class="fas fa-plus-circle" style="margin-right: 0.5rem;"></i> Create Personnel Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>