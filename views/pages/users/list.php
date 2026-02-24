<?php
// Calculate simple stats
$totalUsers = count($users);
$inspectors = count(array_filter($users, fn($u) => $u['role_name'] === 'Inspector'));
$admins = count(array_filter($users, fn($u) => $u['role_name'] === 'Admin'));
?>

<style>
    .users-page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2rem;
    }

    .user-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-mini-card {
        background: var(--card-bg-1);
        border: 1px solid var(--border-color-1);
        padding: 1.5rem;
        border-radius: 16px;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        transition: transform 0.2s ease;
    }

    .stat-mini-card:hover {
        transform: translateY(-3px);
    }

    .stat-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .stat-info .value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-color-1);
        line-height: 1;
    }

    .stat-info .label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-secondary-1);
        letter-spacing: 0.5px;
        margin-top: 0.25rem;
    }

    .premium-table-card {
        background: var(--card-bg-1);
        border: 1px solid var(--border-color-1);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }

    .table-header-controls {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color-1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .search-wrapper {
        position: relative;
        width: 350px;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.8rem;
        border-radius: 12px;
        border: 1px solid var(--border-color-1);
        background: var(--bg-color-1);
        color: var(--text-color-1);
        font-size: 0.9rem;
        outline: none;
        transition: all 0.2s ease;
    }

    .search-input:focus {
        border-color: var(--primary-color-1);
        box-shadow: 0 0 0 4px rgba(var(--primary-color-1-rgb), 0.1);
    }

    .user-table {
        width: 100%;
        border-collapse: collapse;
    }

    .user-table th {
        padding: 1.25rem 2rem;
        text-align: left;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-secondary-1);
        border-bottom: 2px solid var(--border-color-1);
    }

    .user-table td {
        padding: 1.25rem 2rem;
        border-bottom: 1px solid var(--border-color-1);
        vertical-align: middle;
    }

    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        color: white;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .role-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .action-button {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-color-1);
        color: var(--text-secondary-1);
        background: transparent;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .action-button:hover {
        background: var(--bg-color-1);
        color: var(--primary-color-1);
        border-color: var(--primary-color-1);
        transform: translateY(-2px);
    }

    .action-button.danger:hover {
        background: #fff1f2;
        color: #e11d48;
        border-color: #fecaca;
    }
</style>

<div class="user-management-view">
    <!-- Header -->
    <div class="users-page-header">
        <div>
            <h2 style="font-weight: 800; font-size: 1.75rem; margin: 0; letter-spacing: -0.5px; color: var(--text-color-1);">Personnel Directory</h2>
            <p style="color: var(--text-secondary-1); font-weight: 500; margin: 0.25rem 0 0;">Manage municipal health & safety officers and staff.</p>
        </div>
        <a href="/users/create" class="btn btn-primary" style="background: var(--primary-color-1); padding: 0.8rem 1.75rem; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 0.6rem; border: none; color: white;">
            <i class="fas fa-plus"></i> Add Account
        </a>
    </div>

    <!-- Quick Stats -->
    <div class="user-stats-grid">
        <div class="stat-mini-card">
            <div class="stat-icon-box" style="background: rgba(var(--primary-color-1-rgb), 0.1); color: var(--primary-color-1);">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <div class="value"><?= $totalUsers ?></div>
                <div class="label">Total Workforce</div>
            </div>
        </div>
        
        <div class="stat-mini-card">
            <div class="stat-icon-box" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="stat-info">
                <div class="value"><?= $inspectors ?></div>
                <div class="label">Active Inspectors</div>
            </div>
        </div>

        <div class="stat-mini-card">
            <div class="stat-icon-box" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9;">
                <i class="fas fa-shield-halved"></i>
            </div>
            <div class="stat-info">
                <div class="value"><?= $admins ?></div>
                <div class="label">Administrators</div>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="premium-table-card">
        <div class="table-header-controls">
            <div class="search-wrapper">
                <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1); opacity: 0.6;"></i>
                <input type="text" id="userSearch" class="search-input" placeholder="Find personnel by name or ID...">
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <button class="btn" style="background: white; border: 1px solid var(--border-color-1); padding: 0.6rem 1rem; border-radius: 10px; font-size: 0.85rem; font-weight: 700; color: var(--text-color-1);">
                    <i class="fas fa-file-export me-1"></i> Export List
                </button>
            </div>
        </div>

        <table class="user-table">
            <thead>
                <tr>
                    <th>Workforce Member</th>
                    <th>Official Rank</th>
                    <th>Status</th>
                    <th>Onboarding</th>
                    <th style="text-align: right;">Managed By</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <?php
                    $initials = strtoupper(substr($user['full_name'], 0, 1));
                    $colors = ['#10b981', '#0ea5e9', '#6366f1', '#f59e0b', '#ef4444', '#4c8a89'];
                    $bgColor = $colors[array_sum(array_map('ord', str_split($user['full_name']))) % count($colors)];
                    ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div class="user-avatar" style="background: <?= $bgColor ?>;">
                                    <?= $initials ?>
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: var(--text-color-1); font-size: 0.95rem;"><?= htmlspecialchars($user['full_name']) ?></div>
                                    <div style="font-size: 0.8rem; color: var(--text-secondary-1); font-weight: 500;"><?= htmlspecialchars($user['email']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php
                            $roleColor = match($user['role_name']) {
                                'Admin' => '#ef4444',
                                'Inspector' => '#10b981',
                                'Clerk' => '#0ea5e9',
                                default => '#64748b'
                            };
                            ?>
                            <div class="role-badge" style="background: rgba(<?= hexdec(substr($roleColor, 1, 2)) ?>, <?= hexdec(substr($roleColor, 3, 2)) ?>, <?= hexdec(substr($roleColor, 5, 2)) ?>, 0.1); color: <?= $roleColor ?>;">
                                <i class="fas fa-<?= $user['role_name'] === 'Admin' ? 'crown' : ($user['role_name'] === 'Inspector' ? 'magnifying-glass' : 'pen-nib') ?>" style="font-size: 0.65rem;"></i>
                                <?= htmlspecialchars($user['role_name']) ?>
                            </div>
                        </td>
                        <td>
                            <span style="display: flex; align-items: center; gap: 0.4rem; color: #10b981; font-size: 0.75rem; font-weight: 800;">
                                <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></span>
                                ACTIVE
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--text-color-1); font-size: 0.85rem;"><?= date('M d, Y', strtotime($user['created_at'])) ?></div>
                            <div style="font-size: 0.7rem; color: var(--text-secondary-1); font-weight: 500;">Joined Project</div>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                <a href="/users/edit?id=<?= $user['id'] ?>" class="action-button" title="Edit Profile">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <?php if ($user['id'] != ($_SESSION['user']['id'] ?? 0)): ?>
                                    <a href="/users/delete?id=<?= $user['id'] ?>" class="action-button danger" onclick="return confirm('Suspend and archive this account?')" title="Delete User">
                                        <i class="fas fa-trash-can"></i>
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

<script>
    document.getElementById('userSearch').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('.user-table tbody tr');
        
        rows.forEach(row => {
            const name = row.cells[0].textContent.toLowerCase();
            const email = row.cells[0].textContent.toLowerCase();
            if (name.includes(term)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
