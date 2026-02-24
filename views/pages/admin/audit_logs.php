<?php
/**
 * System Audit Logs View - Premium Theme-Aware Version
 */
?>

<style>
    /* Theme-Aware Variables for Audit Component */
    :root {
        --audit-accent-1: #10b981;
        --audit-bg-inner: rgba(255, 255, 255, 0.03);
        --audit-border-subtle: rgba(255, 255, 255, 0.05);
    }

    [data-theme="light"] {
        --audit-bg-inner: rgba(0, 0, 0, 0.02);
        --audit-border-subtle: rgba(0, 0, 0, 0.05);
    }

    /* Reset main container padding for this page */
    .main-container {
        padding: 1.5rem 2rem !important;
    }

    .audit-master-container {
        width: 100%;
    }

    .audit-grid {
        display: grid;
        grid-template-columns: 340px 1fr;
        gap: 2.5rem;
        align-items: start;
        width: 100%;
    }

    .audit-sidebar {
        width: 100%;
        position: sticky;
        top: 90px;
    }

    .filter-panel {
        background: var(--card-bg-1);
        border: 1px solid var(--border-color-1);
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 15px 35px var(--shadow-1);
    }

    .search-title {
        font-weight: 800;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 2.5px;
        color: var(--audit-accent-1);
        margin-bottom: 2.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .filter-label {
        display: block;
        font-size: 0.7rem;
        font-weight: 800;
        color: var(--text-secondary-1);
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 0.75rem;
    }

    .glass-input {
        width: 100%;
        padding: 0.9rem 1.25rem;
        background: var(--bg-color-1);
        border: 1px solid var(--border-color-1);
        border-radius: 12px;
        color: var(--text-color-1);
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.3s ease;
        outline: none;
    }

    .glass-input:focus {
        border-color: var(--audit-accent-1);
        background: var(--card-bg-1);
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .btn-query {
        background: var(--audit-accent-1);
        color: white;
        border: none;
        padding: 1.1rem;
        border-radius: 14px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 0.8rem;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .btn-query:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        filter: brightness(1.1);
    }

    .log-feed {
        width: 100%;
        min-width: 0;
    }

    .log-container {
        display: flex;
        flex-direction: column;
        gap: 1.75rem;
        width: 100%;
    }

    .log-card {
        background: var(--card-bg-1);
        border: 1px solid var(--border-color-1);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        width: 100%;
        box-shadow: 0 4px 15px var(--shadow-1);
    }

    .log-card:hover {
        transform: translateX(10px);
        border-color: var(--audit-accent-1);
        box-shadow: -5px 5px 30px var(--shadow-1);
    }

    .log-stripe {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 6px;
    }

    .card-top {
        padding: 1.5rem 2.5rem;
        background: var(--audit-bg-inner);
        border-bottom: 1px solid var(--border-color-1);
        display: grid;
        grid-template-columns: 120px 1fr auto;
        align-items: center;
        gap: 2rem;
    }

    .timestamp-box .date {
        display: block;
        font-weight: 800;
        font-size: 0.95rem;
        color: var(--text-color-1);
    }

    .timestamp-box .time {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-secondary-1);
        text-transform: uppercase;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .profile-avatar {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 1rem;
        box-shadow: 0 4px 12px var(--shadow-1);
    }

    .profile-info .name {
        display: block;
        font-weight: 700;
        font-size: 1rem;
        color: var(--text-color-1);
    }

    .profile-info .role {
        font-size: 0.7rem;
        font-weight: 800;
        color: var(--audit-accent-1);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .action-badge-premium {
        padding: 0.6rem 1.25rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .card-content {
        padding: 2.5rem;
    }

    .meta-tags {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .cyber-tag {
        background: var(--audit-bg-inner);
        border: 1px solid var(--border-color-1);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-secondary-1);
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .diff-container {
        background: var(--audit-bg-inner);
        border-radius: 20px;
        border: 1px solid var(--border-color-1);
        overflow: hidden;
    }

    .diff-table-premium {
        width: 100%;
        border-collapse: collapse;
    }

    .diff-table-premium th {
        background: var(--audit-bg-inner);
        padding: 1rem 1.5rem;
        text-align: left;
        font-size: 0.7rem;
        font-weight: 900;
        color: var(--text-secondary-1);
        text-transform: uppercase;
        border-bottom: 1px solid var(--border-color-1);
    }

    .diff-table-premium td {
        padding: 1.5rem;
        border-bottom: 1px solid var(--audit-border-subtle);
        font-size: 0.95rem;
        color: var(--text-color-1);
    }

    .diff-table-premium tr:last-child td {
        border-bottom: none;
    }

    .attr-name {
        font-weight: 800;
        color: var(--text-secondary-1);
        width: 200px;
    }

    .attr-value {
        font-weight: 600;
        color: var(--text-color-1);
    }

    .card-footer-info {
        margin-top: 2rem;
        padding-top: 1.25rem;
        border-top: 1px dashed var(--border-color-1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.75rem;
        color: var(--text-secondary-1);
    }
</style>

<div class="audit-master-container">
    <div class="audit-grid">
        <!-- Sidebar filters -->
        <div class="audit-sidebar">
            <div class="filter-panel shadow-sm">
                <div class="search-title">
                    <i class="fas fa-radar"></i> Active Surveillance
                </div>
                
                <form action="/admin/audit-logs" method="GET">
                    <div class="mb-4">
                        <label class="filter-label">Target Operator</label>
                        <input type="text" name="user" placeholder="Search accounts..." value="<?= htmlspecialchars($currentUser) ?>" class="glass-input">
                    </div>

                    <div class="mb-4">
                        <label class="filter-label">Registry Node</label>
                        <select name="table" class="glass-input">
                            <option value="">Full Registry</option>
                            <?php foreach ($tables as $t): ?>
                                <option value="<?= $t ?>" <?= $currentTable === $t ? 'selected' : '' ?>><?= strtoupper($t) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="filter-label">Operation Vector</label>
                        <select name="action" class="glass-input">
                            <option value="">All Vectors</option>
                            <?php foreach ($actions as $a): ?>
                                <option value="<?= $a ?>" <?= $currentAction === $a ? 'selected' : '' ?>><?= str_replace('_', ' ', strtoupper($a)) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 2rem;">
                        <div>
                            <label class="filter-label">Start Pulse</label>
                            <input type="date" name="start_date" value="<?= $currentStartDate ?>" class="glass-input" style="padding: 0.6rem; font-size: 0.8rem;">
                        </div>
                        <div>
                            <label class="filter-label">End Pulse</label>
                            <input type="date" name="end_date" value="<?= $currentEndDate ?>" class="glass-input" style="padding: 0.6rem; font-size: 0.8rem;">
                        </div>
                    </div>

                    <button type="submit" class="btn-query">
                        <i class="fas fa-satellite-dish"></i> Sync Registry
                    </button>
                    <a href="/admin/audit-logs" style="display: block; text-align: center; margin-top: 1.25rem; color: var(--text-secondary-1); text-decoration: none; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Purge Filters</a>
                </form>
            </div>
        </div>

        <!-- Main Feed -->
        <div class="log-feed">
            <div class="log-container">
                <?php if (empty($logs)): ?>
                    <div style="padding: 8rem 2rem; text-align: center; border: 2px dashed var(--border-color-1); border-radius: 40px; background: var(--audit-bg-inner);">
                        <i class="fas fa-shield-slash fa-4x mb-4" style="color: var(--text-secondary-1);"></i>
                        <h4 style="font-weight: 900; color: var(--text-color-1); letter-spacing: 1px;">NO DATA DETECTED</h4>
                        <p style="color: var(--text-secondary-1);">Current surveillance parameters returned zero matching vectors.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                        <div class="log-card shadow-sm">
                            <?php
                                $accentColor = match($log['action']) {
                                    'CREATE' => '#10b981',
                                    'UPDATE', 'UPDATE_STATUS', 'UPDATE_PHOTO' => '#f59e0b',
                                    'DELETE' => '#ef4444',
                                    'CLAIM_FINE', 'ASSIGN_FINE' => '#0ea5e9',
                                    default => '#64748b'
                                };
                            ?>
                            <div class="log-stripe" style="background: <?= $accentColor ?>"></div>
                            
                            <div class="card-top">
                                <div class="timestamp-box">
                                    <span class="date"><?= date('M d, Y', strtotime($log['timestamp'])) ?></span>
                                    <span class="time"><?= date('H:i:s P', strtotime($log['timestamp'])) ?></span>
                                </div>

                                <div class="user-profile">
                                    <div class="profile-avatar" style="background: <?= $accentColor ?>15; color: <?= $accentColor ?>; border: 1px solid <?= $accentColor ?>30;">
                                        <?= strtoupper($log['user_name'] ? $log['user_name'][0] : 'S') ?>
                                    </div>
                                    <div class="profile-info">
                                        <span class="name"><?= htmlspecialchars($log['user_name'] ?? 'System Process') ?></span>
                                        <span class="role"><?= $log['user_name'] ? 'Operator' : 'Auto-Daemon' ?></span>
                                    </div>
                                </div>

                                <div class="action-badge-premium" style="background: <?= $accentColor ?>15; color: <?= $accentColor ?>; border: 1px solid <?= $accentColor ?>30;">
                                    <?= str_replace('_', ' ', $log['action']) ?>
                                </div>
                            </div>

                            <div class="card-content">
                                <div class="meta-tags">
                                    <div class="cyber-tag"><i class="fas fa-database"></i> Registry: <?= strtoupper($log['table_name']) ?></div>
                                    <div class="cyber-tag"><i class="fas fa-fingerprint"></i> Node: #<?= $log['record_id'] ?></div>
                                </div>

                                <div class="diff-container">
                                    <table class="diff-table-premium">
                                        <thead>
                                            <tr>
                                                <th>Attribute Identifier</th>
                                                <th>Updated Registry Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $data = json_decode($log['changes_json'], true);
                                            if (is_array($data)): 
                                                // Handle old/new status specifically for better UX
                                                if (isset($data['old_status']) && isset($data['new_status'])): ?>
                                                    <tr>
                                                        <td class="attr-name">Previous State</td>
                                                        <td class="attr-value" style="color: var(--text-secondary-1);"><?= htmlspecialchars((string)$data['old_status']) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="attr-name">Transitioned State</td>
                                                        <td class="attr-value" style="color: <?= $accentColor ?>; font-weight: 800; font-size: 1.1rem;"><?= htmlspecialchars((string)$data['new_status']) ?></td>
                                                    </tr>
                                                <?php else: 
                                                    foreach ($data as $key => $val): ?>
                                                        <tr>
                                                            <td class="attr-name"><?= str_replace('_', ' ', strtoupper($key)) ?></td>
                                                            <td class="attr-value">
                                                                <?php if (str_contains(strtolower($key), 'amount') || str_contains(strtolower($key), 'fine')): ?>
                                                                    <span style="color: #ef4444; font-weight: 900; font-size: 1.1rem;">₱<?= number_format((float)$val, 2) ?></span>
                                                                <?php elseif (str_contains(strtolower($key), 'status')): ?>
                                                                    <span style="color: <?= $accentColor ?>; font-weight: 800;"><?= htmlspecialchars((string)$val) ?></span>
                                                                <?php else: ?>
                                                                    <span style="font-family: 'JetBrains Mono', 'Fira Code', monospace; color: var(--text-color-1);"><?= htmlspecialchars(is_array($val) ? json_encode($val) : (string)$val) ?></span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach;
                                                endif; 
                                            else: ?>
                                                <tr>
                                                    <td colspan="2" style="font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; color: var(--text-secondary-1); padding: 2rem; background: var(--audit-bg-inner);">
                                                        <?= htmlspecialchars($log['changes_json']) ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card-footer-info">
                                    <div style="display: flex; gap: 2rem;">
                                        <span><i class="fas fa-network-wired me-2"></i>IPV4: <?= $log['ip_address'] ?></span>
                                        <span style="max-width: 500px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= htmlspecialchars($log['user_agent']) ?>">
                                            <i class="fas fa-terminal me-2"></i>AGENT: <?= htmlspecialchars($log['user_agent']) ?>
                                        </span>
                                    </div>
                                    <div style="font-family: monospace; font-weight: 900; letter-spacing: 1px; color: var(--text-secondary-1);">#LOG-<?= str_pad((string)$log['id'], 6, '0', STR_PAD_LEFT) ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
