<?php
/**
 * System Audit Logs View
 */
?>

<style>
    .log-table th {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-secondary-1);
        padding: 1rem 1.5rem;
    }
    .log-table td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        font-size: 0.85rem;
    }
    .action-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-weight: 800;
        font-size: 0.65rem;
        text-transform: uppercase;
    }
    .changes-pre {
        background: rgba(0,0,0,0.05);
        padding: 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        max-height: 150px;
        overflow-y: auto;
        margin: 0;
        white-space: pre-wrap;
    }
</style>

<div class="card shadow-sm" style="border-radius: 16px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
    <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <h5 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: var(--text-color-1); display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-history text-primary"></i>
                Transaction History
            </h5>
            
            <form action="/admin/audit-logs" method="GET" style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <input type="text" name="user" placeholder="Search User..." value="<?= htmlspecialchars($currentUser) ?>" 
                       style="padding: 0.5rem 1rem; border-radius: 8px; border: 1px solid var(--border-color-1); font-size: 0.85rem;">
                
                <select name="table" style="padding: 0.5rem 1rem; border-radius: 8px; border: 1px solid var(--border-color-1); font-size: 0.85rem;">
                    <option value="">All Tables</option>
                    <?php foreach ($tables as $t): ?>
                        <option value="<?= $t ?>" <?= $currentTable === $t ? 'selected' : '' ?>><?= ucfirst($t) ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="action" style="padding: 0.5rem 1rem; border-radius: 8px; border: 1px solid var(--border-color-1); font-size: 0.85rem;">
                    <option value="">All Actions</option>
                    <?php foreach ($actions as $a): ?>
                        <option value="<?= $a ?>" <?= $currentAction === $a ? 'selected' : '' ?>><?= str_replace('_', ' ', $a) ?></option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1.25rem; border-radius: 8px; font-weight: 700;">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="/admin/audit-logs" class="btn btn-outline-secondary" style="padding: 0.5rem 1.25rem; border-radius: 8px; font-weight: 700;">
                    Clear
                </a>
            </form>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover log-table mb-0">
                <thead style="background: rgba(0,0,0,0.02);">
                    <tr>
                        <th>Timestamp</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Resource</th>
                        <th>Transaction Data</th>
                        <th>Network</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="6" style="padding: 4rem; text-align: center; color: var(--text-secondary-1);">
                                <i class="fas fa-search fa-3x mb-3 opacity-25"></i>
                                <p>No transactions found matching your criteria.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td style="white-space: nowrap;">
                                    <span style="display: block; font-weight: 700;"><?= date('M d, Y', strtotime($log['timestamp'])) ?></span>
                                    <span style="font-size: 0.75rem; color: var(--text-secondary-1);"><?= date('h:i:s A', strtotime($log['timestamp'])) ?></span>
                                </td>
                                <td>
                                    <?php if ($log['user_name']): ?>
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary-color-1); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.7rem;">
                                                <?= strtoupper($log['user_name'][0]) ?>
                                            </div>
                                            <div>
                                                <span style="display: block; font-weight: 700;"><?= htmlspecialchars($log['user_name']) ?></span>
                                                <span style="font-size: 0.7rem; color: var(--text-secondary-1);"><?= htmlspecialchars($log['user_email']) ?></span>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-secondary italic">System / Guest</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                        $actionClass = match($log['action']) {
                                            'CREATE' => 'background: #dcfce7; color: #15803d;',
                                            'UPDATE_STATUS', 'UPDATE' => 'background: #fef9c3; color: #854d0e;',
                                            'DELETE' => 'background: #fef2f2; color: #991b1b;',
                                            'ASSIGN_FINE' => 'background: #e0f2fe; color: #075985;',
                                            default => 'background: #f3f4f6; color: #374151;'
                                        };
                                    ?>
                                    <span class="action-badge" style="<?= $actionClass ?>">
                                        <?= str_replace('_', ' ', $log['action']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: 2px;">
                                        <div style="display: flex; align-items: center; gap: 0.4rem;">
                                            <i class="fas fa-folder text-secondary" style="font-size: 0.75rem;"></i>
                                            <span style="font-weight: 700; font-size: 0.8rem;"><?= strtoupper($log['table_name']) ?></span>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 0.4rem;">
                                            <i class="fas fa-hashtag text-secondary" style="font-size: 0.75rem;"></i>
                                            <span style="font-size: 0.75rem; color: var(--text-secondary-1);">ID: <?= $log['record_id'] ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="changes-pre"><?php 
                                        $data = json_decode($log['changes_json'], true);
                                        echo $data ? json_encode($data, JSON_PRETTY_PRINT) : htmlspecialchars($log['changes_json']);
                                    ?></div>
                                </td>
                                <td>
                                    <div style="font-size: 0.75rem; color: var(--text-secondary-1);">
                                        <div style="display: flex; align-items: center; gap: 0.4rem; margin-bottom: 2px;">
                                            <i class="fas fa-network-wired"></i> <?= $log['ip_address'] ?>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 0.4rem; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= htmlspecialchars($log['user_agent']) ?>">
                                            <i class="fas fa-laptop"></i> <?= htmlspecialchars($log['user_agent']) ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
