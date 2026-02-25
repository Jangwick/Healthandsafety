<div class="card-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
    <!-- Total Establishments -->
    <div class="card card-lift" style="padding: 1.5rem; border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 1.5rem;">
            <div>
                <h3 style="color: var(--text-secondary-1); font-size: 0.875rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Total Establishments</h3>
                <p style="color: var(--text-color-1); font-size: 2.25rem; font-weight: 700; line-height: 1; margin: 0;"><?= $stats['total_establishments'] ?? 0 ?></p>
            </div>
            <div style="background: rgba(76, 138, 137, 0.1); padding: 12px; border-radius: 12px; color: var(--primary-color-1);">
                <i class="fas fa-building fa-2x"></i>
            </div>
        </div>
        <div style="font-size: 0.875rem; color: var(--text-secondary-1);">
            <span style="color: <?= $stats['est_trend'] > 0 ? '#10b981' : '#64748b' ?>; font-weight: 600;">
                <i class="fas fa-arrow-up"></i> <?= $stats['est_trend'] ?>%
            </span> 
            <span style="margin-left: 0.5rem;">new this month</span>
        </div>
    </div>

    <!-- Active Inspections -->
    <div class="card card-lift" style="padding: 1.5rem; border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 1.5rem;">
            <div>
                <h3 style="color: var(--text-secondary-1); font-size: 0.875rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Active Inspections</h3>
                <p style="color: var(--text-color-1); font-size: 2.25rem; font-weight: 700; line-height: 1; margin: 0;"><?= $stats['active_inspections'] ?? 0 ?></p>
            </div>
            <div style="background: rgba(14, 165, 233, 0.1); padding: 12px; border-radius: 12px; color: #0ea5e9;">
                <i class="fas fa-clipboard-check fa-2x"></i>
            </div>
        </div>
        <div style="font-size: 0.875rem; color: var(--text-secondary-1);">
            <span style="color: <?= ($stats['insp_trend'] ?? 0) >= 0 ? '#10b981' : '#ef4444' ?>; font-weight: 600;">
                <i class="fas fa-arrow-<?= ($stats['insp_trend'] ?? 0) >= 0 ? 'up' : 'down' ?>"></i> <?= abs($stats['insp_trend'] ?? 0) ?>%
            </span> 
            <span style="margin-left: 0.5rem;">scheduled weekly</span>
        </div>
    </div>

    <!-- Violations Detected -->
    <div class="card card-lift" style="padding: 1.5rem; border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 1.5rem;">
            <div>
                <h3 style="color: var(--text-secondary-1); font-size: 0.875rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Pending Violations</h3>
                <p style="color: var(--text-color-1); font-size: 2.25rem; font-weight: 700; line-height: 1; margin: 0;"><?= $stats['total_violations'] ?? 0 ?></p>
            </div>
            <div style="background: rgba(245, 158, 11, 0.1); padding: 12px; border-radius: 12px; color: #f59e0b;">
                <i class="fas fa-exclamation-triangle fa-2x"></i>
            </div>
        </div>
        <div style="font-size: 0.875rem; color: var(--text-secondary-1);">
            <span style="color: <?= ($stats['violation_trend'] ?? 0) > 0 ? '#ef4444' : '#10b981' ?>; font-weight: 600;">
                <i class="fas fa-arrow-<?= ($stats['violation_trend'] ?? 0) > 0 ? 'up' : 'down' ?>"></i> <?= abs($stats['violation_trend'] ?? 0) ?>%
            </span> 
            <span style="margin-left: 0.5rem;">from last week</span>
        </div>
    </div>

    <!-- Compliance Rate -->
    <div class="card card-lift" style="padding: 1.5rem; border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 1.5rem;">
            <div>
                <h3 style="color: var(--text-secondary-1); font-size: 0.875rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Compliance Score</h3>
                <p style="color: var(--text-color-1); font-size: 2.25rem; font-weight: 700; line-height: 1; margin: 0;"><?= $stats['compliance_rate'] ?? 0 ?>%</p>
            </div>
            <div style="background: rgba(16, 185, 129, 0.1); padding: 12px; border-radius: 12px; color: #10b981;">
                <i class="fas fa-chart-line fa-2x"></i>
            </div>
        </div>
        <div style="font-size: 0.875rem; color: var(--text-secondary-1);">
            <span style="color: #10b981; font-weight: 600;"><i class="fas fa-check-circle"></i> Healthy</span> 
            <span style="margin-left: 0.5rem;">system average</span>
        </div>
    </div>

    <!-- Revenue / Fines -->
    <div class="card card-lift" style="padding: 1.5rem; border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 1.5rem;">
            <div>
                <h3 style="color: var(--text-secondary-1); font-size: 0.875rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Fines Collected</h3>
                <p style="color: var(--text-color-1); font-size: 2rem; font-weight: 700; line-height: 1; margin: 0;">₱<?= number_format($stats['total_fines'], 0) ?></p>
            </div>
            <div style="background: rgba(99, 102, 241, 0.1); padding: 12px; border-radius: 12px; color: #6366f1;">
                <i class="fas fa-wallet fa-2x"></i>
            </div>
        </div>
        <div style="font-size: 0.875rem; color: var(--text-secondary-1);">
            <span style="color: #f59e0b; font-weight: 600;">₱<?= number_format($stats['pending_fines'], 0) ?></span> 
            <span style="margin-left: 0.5rem;">pending collection</span>
        </div>
    </div>
</div>

<div class="card shadow-sm" style="border-radius: 12px; overflow: hidden; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
    <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; color: var(--text-color-1);">Recent Inspections Activity</h3>
        <a href="/inspections" class="btn btn-sm btn-outline-primary" style="padding: 0.4rem 0.8rem; border-radius: 6px; text-decoration: none; font-size: 0.875rem; border: 1px solid var(--primary-color-1); color: var(--primary-color-1);">View Reports</a>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-container" style="border: none; box-shadow: none; width: 100%; overflow-x: auto;">
            <table class="datatable" style="width: 100% !important; border-collapse: separate; border-spacing: 0; table-layout: fixed;">
                <thead>
                    <tr style="background: rgba(var(--header-bg-1-rgb), 0.4);">
                        <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1); letter-spacing: 0.05em; width: 40%;">Establishment Name</th>
                        <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1); letter-spacing: 0.05em; width: 20%;">Category</th>
                        <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1); letter-spacing: 0.05em; width: 20%;">Date Scheduled</th>
                        <th style="padding: 1.25rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1); letter-spacing: 0.05em; width: 20%;">Safety Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recent_inspections)): ?>
                        <tr>
                            <td colspan="4" style="padding: 5rem 2rem; text-align: center; color: var(--text-secondary-1);">
                                <div style="opacity: 0.2; margin-bottom: 1.5rem;">
                                    <i class="fas fa-clipboard-list fa-4x"></i>
                                </div>
                                <p style="font-size: 1rem; font-weight: 700; color: var(--text-color-1);">No activity records detected</p>
                                <p style="font-size: 0.85rem; font-weight: 500;">Recently performed inspections will appear here.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recent_inspections as $insp): ?>
                        <tr style="border-bottom: 1px solid var(--border-color-1); transition: background 0.2s;" onmouseover="this.style.background='rgba(var(--primary-color-1-rgb, 76, 138, 137), 0.02)'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 1.25rem 1.5rem;">
                                <div style="display: flex; align-items: center;">
                                    <div style="width: 34px; height: 34px; border-radius: 10px; background: rgba(76, 138, 137, 0.08); color: var(--primary-color-1); display: flex; align-items: center; justify-content: center; margin-right: 1.25rem; border: 1px solid rgba(76, 138, 137, 0.1);">
                                        <i class="fas fa-building" style="font-size: 0.85rem;"></i>
                                    </div>
                                    <div style="font-weight: 700; color: var(--text-color-1); font-size: 0.95rem;"><?= htmlspecialchars($insp['business_name']) ?></div>
                                </div>
                            </td>
                            <td style="padding: 1.25rem 1.5rem;">
                                <span style="font-size: 0.85rem; color: var(--text-secondary-1); font-weight: 500; display: flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-tag" style="font-size: 0.75rem; opacity: 0.6;"></i>
                                    <?= htmlspecialchars($insp['category']) ?>
                                </span>
                            </td>
                            <td style="padding: 1.25rem 1.5rem;">
                                <div style="display: flex; flex-direction: column; gap: 2px;">
                                    <span style="font-size: 0.9rem; color: var(--text-color-1); font-weight: 700;"><?= date('M d, Y', strtotime($insp['scheduled_date'])) ?></span>
                                    <span style="font-size: 0.75rem; color: var(--text-secondary-1); font-style: italic; font-weight: 500;">by <?= htmlspecialchars($insp['inspector_name'] ?? 'System') ?></span>
                                </div>
                            </td>
                            <td style="padding: 1.25rem 1.5rem;">
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
