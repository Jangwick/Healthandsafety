<div class="card shadow-sm" style="border-radius: 12px; overflow: hidden; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
    <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-color-1);">System Users</h3>
            <p style="margin: 0.25rem 0 0; font-size: 0.875rem; color: var(--text-secondary-1);">Manage system access and roles for all personnel</p>
        </div>
        <a href="/users/create" class="btn btn-primary" style="display: flex; align-items: center; gap: 0.5rem; background: var(--primary-color-1); border: none; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 600;">
            <i class="fas fa-user-plus"></i> Add User
        </a>
    </div>
    
    <div class="card-body" style="padding: 1.5rem;">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success d-flex align-items-center mb-4" style="border-radius: 8px; border: none; background: rgba(25, 135, 84, 0.1); color: #198754;">
                <i class="fas fa-check-circle me-2"></i>
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger d-flex align-items-center mb-4" style="border-radius: 8px; border: none; background: rgba(220, 53, 69, 0.1); color: #dc3545;">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <div class="table-container" style="border: none; box-shadow: none; margin: 0;">
            <table class="datatable" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: rgba(0,0,0,0.02);">
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">ID</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">User Information</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Access Role</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Status</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Registration</th>
                        <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users ?? [] as $user): ?>
                        <tr style="border-bottom: 1px solid var(--border-color-1); transition: background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.01)'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 1.25rem 1.5rem; color: var(--text-secondary-1); font-weight: 600;">#<?= $user['id'] ?></td>
                            <td style="padding: 1.25rem 1.5rem;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="width: 40px; height: 40px; border-radius: 10px; background: var(--primary-color-1); display: flex; align-items: center; justify-content: center; font-weight: 700; color: white; font-size: 1.1rem; flex-shrink: 0;">
                                        <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: var(--text-color-1); font-size: 0.95rem;"><?= htmlspecialchars($user['full_name']) ?></div>
                                        <div style="font-size: 0.8rem; color: var(--text-secondary-1);"><?= htmlspecialchars($user['email']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1.25rem 1.5rem;">
                                <span style="background: rgba(76, 138, 137, 0.1); color: var(--primary-color-1); padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <?= htmlspecialchars($user['role_name']) ?>
                                </span>
                            </td>
                            <td style="padding: 1.25rem 1.5rem;">
                                <span style="background: rgba(25, 135, 84, 0.1); color: #198754; padding: 4px 10px; border-radius: 50px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">
                                    Active
                                </span>
                            </td>
                            <td style="padding: 1.25rem 1.5rem; color: var(--text-secondary-1); font-size: 0.85rem;">
                                <?= date('M d, Y', strtotime($user['created_at'])) ?>
                            </td>
                            <td style="padding: 1.25rem 1.5rem; text-align: right;">
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <?php if ($user['role_name'] === 'Inspector'): ?>
                                        <a href="/inspections/create?inspector_id=<?= $user['id'] ?>" class="btn btn-sm" style="background: rgba(25, 135, 84, 0.1); color: #198754; border: none; padding: 6px 10px; border-radius: 8px;" title="Schedule Audit">
                                            <i class="fas fa-calendar-plus"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="/users/edit?id=<?= $user['id'] ?>" class="btn btn-sm" style="background: rgba(0,0,0,0.05); color: var(--text-color-1); border: none; padding: 6px 10px; border-radius: 8px;" title="Edit Profile">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if ($user['id'] != ($_SESSION['user']['id'] ?? 0)): ?>
                                        <a href="/users/delete?id=<?= $user['id'] ?>" class="btn btn-sm" style="background: rgba(220, 53, 69, 0.1); color: #dc3545; border: none; padding: 6px 10px; border-radius: 8px;" onclick="return confirm('Archive this user account?')" title="Delete User">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
