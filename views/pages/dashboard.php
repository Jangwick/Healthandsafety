<div class="card-grid dashboard-grid">
    <!-- Total Establishments -->
    <div class="card card-lift">
        <div class="card-stat-header">
            <div class="card-stat-info">
                <h3 class="stat-label">Total Establishments</h3>
                <p class="stat-value"><?= $stats['total_establishments'] ?? 0 ?></p>
            </div>
            <div class="stat-icon-wrapper bg-soft-primary">
                <i class="fas fa-building fa-2x"></i>
            </div>
        </div>
        <div class="stat-footer">
            <span class="trend-indicator <?= $stats['est_trend'] > 0 ? 'trend-up' : 'trend-neutral' ?>">
                <i class="fas fa-arrow-up"></i> <?= $stats['est_trend'] ?>%
            </span> 
            <span class="trend-text">new this month</span>
        </div>
    </div>

    <!-- Active Inspections -->
    <div class="card card-lift">
        <div class="card-stat-header">
            <div class="card-stat-info">
                <h3 class="stat-label">Active Inspections</h3>
                <p class="stat-value"><?= $stats['active_inspections'] ?? 0 ?></p>
            </div>
            <div class="stat-icon-wrapper bg-soft-info">
                <i class="fas fa-clipboard-check fa-2x"></i>
            </div>
        </div>
        <div class="stat-footer">
            <span class="trend-indicator <?= ($stats['insp_trend'] ?? 0) >= 0 ? 'trend-up' : 'trend-down' ?>">
                <i class="fas fa-arrow-<?= ($stats['insp_trend'] ?? 0) >= 0 ? 'up' : 'down' ?>"></i> <?= abs($stats['insp_trend'] ?? 0) ?>%
            </span> 
            <span class="trend-text">scheduled weekly</span>
        </div>
    </div>

    <!-- Violations Detected -->
    <div class="card card-lift">
        <div class="card-stat-header">
            <div class="card-stat-info">
                <h3 class="stat-label">Pending Violations</h3>
                <p class="stat-value"><?= $stats['total_violations'] ?? 0 ?></p>
            </div>
            <div class="stat-icon-wrapper bg-soft-warning">
                <i class="fas fa-exclamation-triangle fa-2x"></i>
            </div>
        </div>
        <div class="stat-footer">
            <span class="trend-indicator <?= ($stats['violation_trend'] ?? 0) > 0 ? 'trend-down' : 'trend-up' ?>">
                <i class="fas fa-arrow-<?= ($stats['violation_trend'] ?? 0) > 0 ? 'up' : 'down' ?>"></i> <?= abs($stats['violation_trend'] ?? 0) ?>%
            </span> 
            <span class="trend-text">from last week</span>
        </div>
    </div>

    <!-- Compliance Rate -->
    <div class="card card-lift">
        <div class="card-stat-header">
            <div class="card-stat-info">
                <h3 class="stat-label">Compliance Score</h3>
                <p class="stat-value"><?= $stats['compliance_rate'] ?? 0 ?>%</p>
            </div>
            <div class="stat-icon-wrapper bg-soft-success">
                <i class="fas fa-chart-line fa-2x"></i>
            </div>
        </div>
        <div class="stat-footer">
            <span class="trend-indicator trend-up"><i class="fas fa-check-circle"></i> Healthy</span> 
            <span class="trend-text">system average</span>
        </div>
    </div>

    <!-- Revenue / Fines -->
    <div class="card card-lift">
        <div class="card-stat-header">
            <div class="card-stat-info">
                <h3 class="stat-label">Fines Collected</h3>
                <p class="stat-value">₱<?= number_format($stats['total_fines'], 0) ?></p>
            </div>
            <div class="stat-icon-wrapper bg-soft-indigo">
                <i class="fas fa-wallet fa-2x"></i>
            </div>
        </div>
        <div class="stat-footer">
            <span class="trend-indicator trend-warning">₱<?= number_format($stats['pending_fines'], 0) ?></span> 
            <span class="trend-text">pending collection</span>
        </div>
    </div>
</div>

<div class="card shadow-sm recent-activity-card">
    <div class="card-header">
        <h3>Recent Inspections Activity</h3>
        <a href="/inspections" class="btn btn-sm btn-outline-primary">View Reports</a>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="datatable">
                <thead>
                    <tr>
                        <th style="width: 40%;">Establishment Name</th>
                        <th style="width: 20%;">Category</th>
                        <th style="width: 20%;">Date Scheduled</th>
                        <th style="width: 20%;">Safety Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recent_inspections)): ?>
                        <tr>
                            <td colspan="4" class="empty-table-state">
                                <div class="empty-icon">
                                    <i class="fas fa-clipboard-list fa-4x"></i>
                                </div>
                                <p class="empty-title">No activity records detected</p>
                                <p class="empty-subtitle">Recently performed inspections will appear here.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recent_inspections as $insp): ?>
                        <tr>
                            <td>
                                <div class="establishment-cell">
                                    <div class="est-icon">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div class="est-name"><?= htmlspecialchars($insp['business_name']) ?></div>
                                </div>
                            </td>
                            <td>
                                <span class="category-tag">
                                    <i class="fas fa-tag"></i>
                                    <?= htmlspecialchars($insp['category']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="date-cell">
                                    <span class="main-date"><?= date('M d, Y', strtotime($insp['scheduled_date'])) ?></span>
                                    <span class="inspector-name">by <?= htmlspecialchars($insp['inspector_name'] ?? 'System') ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-<?= $insp['status'] === 'Completed' ? 'verified' : strtolower($insp['status']) ?>">
                                    <i class="fas fa-<?= $insp['status'] === 'Completed' ? 'check-circle' : 'clock' ?>"></i>
                                    <?= $insp['status'] === 'Completed' ? 'VERIFIED' : $insp['status'] ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if (!empty($alerts)): ?>
<div class="card shadow-sm" style="margin-top: 2rem; border-radius: 12px; border: 1px solid #fee2e2; background: #fffafb;">
    <div class="card-header" style="background: transparent; border-bottom: 1px solid #fee2e2; padding: 1.25rem 1.5rem;">
        <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #991b1b; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-exclamation-circle"></i>
            Critical Compliance Alerts
        </h3>
    </div>
    <div class="card-body" style="padding: 1rem 1.5rem;">
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <?php foreach ($alerts as $alert): ?>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: white; border: 1px solid #fee2e2; border-radius: 10px;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #fee2e2; color: #ef4444; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-biohazard"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; color: var(--text-color-1);"><?= htmlspecialchars($alert['business_name']) ?></div>
                        <div style="font-size: 0.8rem; color: var(--text-secondary-1);"><?= htmlspecialchars($alert['description']) ?></div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="font-weight: 800; color: #ef4444;">₱<?= number_format($alert['fine_amount'], 2) ?></div>
                    <a href="/violations/show?id=<?= $alert['id'] ?>" style="font-size: 0.75rem; font-weight: 700; color: var(--primary-color-1); text-decoration: none;">Take Action</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>
