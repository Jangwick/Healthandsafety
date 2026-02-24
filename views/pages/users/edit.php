<style>
    .edit-user-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .premium-card {
        border-radius: 20px;
        background: var(--card-bg-1);
        border: 1px solid var(--border-color-1);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    }

    .card-banner {
        background: linear-gradient(135deg, var(--primary-color-1) 0%, #3d6e6d 100%);
        padding: 2.5rem 2rem;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .avatar-circle {
        width: 64px;
        height: 64px;
        background: rgba(255,255,255,0.2);
        border: 2px solid rgba(255,255,255,0.4);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 800;
        backdrop-filter: blur(4px);
    }

    .form-section {
        padding: 2.5rem;
    }

    .input-group-custom {
        margin-bottom: 2rem;
    }

    .input-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-secondary-1);
        margin-bottom: 0.75rem;
    }

    .field-wrapper {
        position: relative;
        transition: transform 0.2s ease;
    }

    .field-wrapper:focus-within {
        transform: translateY(-2px);
    }

    .field-icon {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary-1);
        font-size: 1rem;
        pointer-events: none;
        transition: color 0.3s ease;
    }

    .custom-input {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        border: 1px solid var(--border-color-1);
        border-radius: 12px;
        background: var(--bg-color-1);
        color: var(--text-color-1);
        font-size: 0.95rem;
        font-weight: 600;
        transition: all 0.3s ease;
        outline: none;
    }

    .custom-input:focus {
        border-color: var(--primary-color-1);
        background: var(--card-bg-1);
        box-shadow: 0 0 0 4px rgba(var(--primary-color-1-rgb), 0.1);
    }

    .custom-input:focus + .field-icon {
        color: var(--primary-color-1);
    }

    .role-select {
        cursor: pointer;
        appearance: none;
    }

    .role-info-badge {
        position: absolute;
        right: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.7rem;
        font-weight: 800;
        background: rgba(var(--primary-color-1-rgb), 0.1);
        color: var(--primary-color-1);
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        pointer-events: none;
    }

    .action-bar {
        background: rgba(var(--header-bg-1-rgb), 0.3);
        padding: 1.5rem 2.5rem;
        border-top: 1px solid var(--border-color-1);
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .btn-save {
        background: var(--primary-color-1);
        color: white;
        border: none;
        padding: 1rem 3rem;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(var(--primary-color-1-rgb), 0.3);
        filter: brightness(1.1);
    }

    .btn-cancel {
        background: white;
        border: 1px solid var(--border-color-1);
        color: var(--text-color-1);
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
    }

    .btn-cancel:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .password-hint {
        font-size: 0.8rem;
        color: var(--text-secondary-1);
        margin-top: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
</style>

<div class="edit-user-container">
    <div class="premium-card">
        <!-- Banner/Header Section -->
        <div class="card-banner">
            <div class="profile-header">
                <div class="avatar-circle">
                    <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                </div>
                <div>
                    <h2 style="font-weight: 800; font-size: 1.5rem; margin: 0; letter-spacing: -0.5px;">Update Account Settings</h2>
                    <p style="margin: 0.25rem 0 0; opacity: 0.8; font-size: 0.9rem; font-weight: 500;">Modifying profile for <span style="font-weight: 700;"><?= htmlspecialchars($user['full_name']) ?></span></p>
                </div>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; background: rgba(255,255,255,0.2); padding: 0.3rem 0.8rem; border-radius: 50px;">Account ID: #<?= $user['id'] ?></div>
            </div>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div style="margin: 2rem 2.5rem 0; padding: 1.25rem; background: #fff1f2; border: 1px solid #fecaca; border-radius: 12px; color: #e11d48; display: flex; align-items: center; gap: 1rem; font-weight: 600;">
                <i class="fas fa-circle-exclamation"></i>
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <form action="/users/update" method="POST">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            
            <div class="form-section">
                <!-- Legal Name -->
                <div class="input-group-custom">
                    <label class="input-label">Full Legal Name</label>
                    <div class="field-wrapper">
                        <i class="fas fa-id-card field-icon"></i>
                        <input type="text" name="full_name" required value="<?= htmlspecialchars($user['full_name']) ?>" 
                            placeholder="John Doe" class="custom-input">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                    <!-- Email Address -->
                    <div class="input-group-custom" style="margin-bottom: 0;">
                        <label class="input-label">Official Email Address</label>
                        <div class="field-wrapper">
                            <i class="fas fa-at field-icon"></i>
                            <input type="email" name="email" required value="<?= htmlspecialchars($user['email']) ?>" 
                                placeholder="j.doe@lgu.gov.ph" class="custom-input">
                        </div>
                    </div>

                    <!-- Role Access -->
                    <div class="input-group-custom" style="margin-bottom: 0;">
                        <label class="input-label">System Access Role</label>
                        <div class="field-wrapper">
                            <i class="fas fa-shield-halved field-icon"></i>
                            <select name="role_id" required class="custom-input role-select">
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role['id'] ?>" <?= $user['role_id'] == $role['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($role['name']) ?> (Lvl: <?= $role['hierarchy_level'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <i class="fas fa-chevron-down" style="position: absolute; right: 1.25rem; top: 50%; transform: translateY(-50%); opacity: 0.5; font-size: 0.8rem; pointer-events: none;"></i>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="input-group-custom" style="margin-bottom: 0;">
                    <label class="input-label">Security Modification</label>
                    <div class="field-wrapper">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password" name="password" placeholder="••••••••••••" class="custom-input">
                    </div>
                    <div class="password-hint">
                        <i class="fas fa-circle-info" style="font-size: 0.75rem;"></i>
                        <span>Leave empty to retain the current encrypted password layer.</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Actions -->
            <div class="action-bar">
                <a href="/users" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-save">
                    <i class="fas fa-check-double"></i> Apply Changes
                </button>
            </div>
        </form>
    </div>
</div>