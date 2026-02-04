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
            <span style="color: #10b981; font-weight: 600;"><i class="fas fa-arrow-up"></i> 12%</span> 
            <span style="margin-left: 0.5rem;">since last month</span>
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
            <span style="color: #10b981; font-weight: 600;"><i class="fas fa-arrow-up"></i> 5%</span> 
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
            <span style="color: #ef4444; font-weight: 600;"><i class="fas fa-arrow-down"></i> 3%</span> 
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
            <span style="color: #10b981; font-weight: 600;"><i class="fas fa-arrow-up"></i> 0.5%</span> 
            <span style="margin-left: 0.5rem;">system average</span>
        </div>
    </div>
</div>

<div class="card shadow-sm" style="border-radius: 12px; overflow: hidden; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
    <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; color: var(--text-color-1);">Recent Inspections Activity</h3>
        <a href="/inspections" class="btn btn-sm btn-outline-primary" style="padding: 0.4rem 0.8rem; border-radius: 6px; text-decoration: none; font-size: 0.875rem; border: 1px solid var(--primary-color-1); color: var(--primary-color-1);">View Reports</a>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-container" style="border: none; box-shadow: none;">
            <table class="datatable" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: rgba(0,0,0,0.02);">
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Establishment Name</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Category</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Date Scheduled</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Safety Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recent_inspections)): ?>
                        <tr>
                            <td colspan="4" style="padding: 4rem 2rem; text-align: center; color: var(--text-secondary-1);">
                                <div style="opacity: 0.2; margin-bottom: 1rem;">
                                    <i class="fas fa-clipboard-list fa-4x"></i>
                                </div>
                                <p style="font-size: 1rem; font-weight: 500;">No inspection logs available yet</p>
                                <p style="font-size: 0.875rem;">Recently performed inspections will appear here.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recent_inspections as $insp): ?>
                        <tr style="border-bottom: 1px solid var(--border-color-1);">
                            <td style="padding: 1.25rem 1.5rem;">
                                <div style="font-weight: 600; color: var(--text-color-1);"><?= htmlspecialchars($insp['business_name']) ?></div>
                                <div style="font-size: 0.75rem; color: var(--text-secondary-1);">Ref ID: #<?= $insp['id'] ?></div>
                            </td>
                            <td style="padding: 1.25rem 1.5rem; color: var(--text-secondary-1);"><?= htmlspecialchars($insp['category'] ?? 'General') ?></td>
                            <td style="padding: 1.25rem 1.5rem; color: var(--text-secondary-1);"><?= date('M d, Y', strtotime($insp['scheduled_date'])) ?></td>
                            <td style="padding: 1.25rem 1.5rem;">
                                <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $insp['status'])) ?>" style="padding: 0.35rem 0.75rem; border-radius: 50px; font-size: 0.75rem; font-weight: 600;">
                                    <?= $insp['status'] ?>
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
