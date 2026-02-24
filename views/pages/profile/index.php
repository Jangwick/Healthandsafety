<style>
    .profile-container {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 2rem;
        align-items: start;
        padding-top: 1rem;
    }

    .profile-card {
        background: var(--card-bg-1);
        border: 1px solid var(--border-color-1);
        border-radius: 20px;
        overflow: hidden;
        position: sticky;
        top: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .profile-banner {
        height: 100px;
        background: linear-gradient(135deg, var(--primary-color-1), #5ca4a3);
    }

    .avatar-wrapper {
        margin-top: -50px;
        text-align: center;
        padding: 0 1.5rem 1.5rem;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-color-1);
        margin: 0 auto 1rem;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        border: 4px solid var(--card-bg-1);
    }

    .profile-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-color-1);
        margin-bottom: 0.25rem;
    }

    .profile-role {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-secondary-1);
        letter-spacing: 1px;
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background: rgba(0,0,0,0.03);
        border-radius: 50px;
    }

    .settings-card {
        background: var(--card-bg-1);
        border: 1px solid var(--border-color-1);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .form-group-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text-color-1);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-group-title i {
        color: var(--primary-color-1);
        font-size: 1rem;
    }

    .input-wrapper {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .input-wrapper label {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-secondary-1);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .modern-input {
        width: 100%;
        padding: 0.8rem 1.25rem;
        border: 1.5px solid var(--border-color-1);
        border-radius: 12px;
        background: var(--input-bg-1);
        color: var(--text-color-1);
        font-weight: 500;
        transition: all 0.2s;
    }

    .modern-input:focus {
        border-color: var(--primary-color-1);
        box-shadow: 0 0 0 4px rgba(76, 138, 137, 0.1);
        outline: none;
    }

    .password-hint {
        font-size: 0.75rem;
        color: var(--text-secondary-1);
        background: rgba(0,0,0,0.02);
        padding: 0.75rem 1rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .status-alert {
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
    }
</style>

<div class="profile-container">
    <!-- Left column: Profile Summary -->
    <div class="profile-card">
        <div class="profile-banner"></div>
        <div class="avatar-wrapper">
            <div class="profile-avatar">
                <?php 
                    $initials = '';
                    $words = explode(' ', $profile['full_name']);
                    foreach ($words as $w) $initials .= $w[0];
                    echo strtoupper(substr($initials, 0, 2));
                ?>
            </div>
            <h2 class="profile-name"><?= htmlspecialchars($profile['full_name']) ?></h2>
            <span class="profile-role"><?= htmlspecialchars($profile['role_name']) ?></span>
            
            <div style="margin-top: 2rem; text-align: left; padding: 0 0.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: center; color: var(--text-secondary-1);">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase;">Email Address</div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-color-1);"><?= htmlspecialchars($profile['email']) ?></div>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: center; color: var(--text-secondary-1);">
                        <i class="fas fa-id-badge"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase;">Account ID</div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-color-1);">#<?= $profile['id'] ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right column: Edit Form -->
    <div class="settings-card">
        <?php if (isset($_GET['success'])): ?>
            <div class="status-alert" style="background: #ecfdf5; color: #059669;">
                <i class="fas fa-check-circle" style="font-size: 1.25rem;"></i>
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="status-alert" style="background: #fef2f2; color: #dc2626;">
                <i class="fas fa-exclamation-circle" style="font-size: 1.25rem;"></i>
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <form action="/profile/update" method="POST">
            <h3 class="form-group-title">
                <i class="fas fa-user-circle"></i> Personal Information
            </h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="input-wrapper">
                    <label>Full Name</label>
                    <input type="text" name="full_name" value="<?= htmlspecialchars($profile['full_name'] ?? '') ?>" required class="modern-input">
                </div>
                <div class="input-wrapper">
                    <label>Email Address</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($profile['email'] ?? '') ?>" required class="modern-input">
                </div>
            </div>

            <h3 class="form-group-title" style="margin-top: 1rem;">
                <i class="fas fa-shield-alt"></i> Security & Authentication
            </h3>
            
            <div class="password-hint">
                <i class="fas fa-info-circle"></i>
                Leave password fields blank if you do not wish to change your current password.
            </div>

            <div class="input-wrapper">
                <label>Current Password</label>
                <input type="password" name="current_password" class="modern-input" placeholder="Enter current password to verify">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="input-wrapper">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="modern-input" placeholder="Min. 8 characters">
                </div>
                <div class="input-wrapper">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" class="modern-input" placeholder="Repeat new password">
                </div>
            </div>

            <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem; border-radius: 12px; font-weight: 800; font-size: 0.95rem; background: var(--primary-color-1); border: none; box-shadow: 0 10px 20px rgba(76, 138, 137, 0.2);">
                    <i class="fas fa-save" style="margin-right: 0.75rem;"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
