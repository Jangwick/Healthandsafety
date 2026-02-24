<div class="row justify-content-center">
    <div class="col-8">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
            <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.5rem;">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-color-1);">My Profile</h3>
                <p style="margin: 0.25rem 0 0; font-size: 0.875rem; color: var(--text-secondary-1);">Manage your account details and credentials</p>
            </div>
            
            <div class="card-body" style="padding: 2rem;">
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success d-flex align-items-center mb-4" style="border-radius: 8px; border: none; background: rgba(25, 135, 84, 0.1); color: #198754; padding: 1rem;">
                        <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>
                        <?= htmlspecialchars($_GET['success']) ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger d-flex align-items-center mb-4" style="border-radius: 8px; border: none; background: rgba(220, 53, 69, 0.1); color: #dc3545; padding: 1rem;">
                        <i class="fas fa-exclamation-circle" style="margin-right: 0.5rem;"></i>
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php endif; ?>

                <form action="/profile/update" method="POST">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <h5 style="font-size: 1rem; font-weight: 700; color: var(--text-color-1); padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-color-1); margin-bottom: 1.5rem;">
                                Personal Information
                            </h5>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">Full Name</label>
                            <input type="text" name="full_name" value="<?= htmlspecialchars($profile['full_name'] ?? '') ?>" required
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1); box-sizing: border-box;">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">Email Address</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($profile['email'] ?? '') ?>" required
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1); box-sizing: border-box;">
                        </div>

                        <div class="col-12 mb-4 mt-2">
                            <h5 style="font-size: 1rem; font-weight: 700; color: var(--text-color-1); padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-color-1); margin-bottom: 1.5rem;">
                                Security Settings
                            </h5>
                            <p style="font-size: 0.875rem; color: var(--text-secondary-1); margin-bottom: 1rem;">Leave password fields blank if you do not wish to change your password.</p>
                        </div>

                        <div class="col-12 mb-4">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">Current Password</label>
                            <input type="password" name="current_password"
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1); box-sizing: border-box;">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">New Password</label>
                            <input type="password" name="new_password"
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1); box-sizing: border-box;">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label style="display: block; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.5rem; color: var(--text-color-1);">Confirm New Password</label>
                            <input type="password" name="confirm_password"
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-color-1); border-radius: 8px; background: var(--input-bg-1); color: var(--text-color-1); box-sizing: border-box;">
                        </div>
                    </div>

                    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color-1); display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn btn-primary" style="background: var(--primary-color-1); border: none; padding: 0.8rem 2.5rem; border-radius: 8px; font-weight: 700; color: white; cursor: pointer;">
                            <i class="fas fa-save" style="margin-right: 0.5rem;"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
