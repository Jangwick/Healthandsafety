<div class="card shadow-sm" style="border-radius: 12px; overflow: hidden; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
    <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-color-1);">Inspection Schedules</h3>
            <p style="margin: 0.25rem 0 0; font-size: 0.875rem; color: var(--text-secondary-1);">Monitor and manage ongoing health & safety audits</p>
        </div>
        <a href="/inspections/create" class="btn btn-primary" style="display: flex; align-items: center; gap: 0.5rem; background: var(--primary-color-1); border: none; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 600;">
            <i class="fas fa-calendar-plus"></i> Schedule New
        </a>
    </div>
    
    <div class="card-body" style="padding: 0;">
        <div class="table-container" style="border: none; box-shadow: none; margin: 0;">
            <table class="datatable" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: rgba(0,0,0,0.02);">
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Target Establishment</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Assigned Inspector</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Schedule</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Status</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Result</th>
                        <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($inspections)): ?>
                        <tr>
                            <td colspan="6" style="padding: 4rem 2rem; text-align: center; color: var(--text-secondary-1);">
                                <i class="fas fa-clipboard-list fa-4x" style="opacity: 0.2; margin-bottom: 1rem;"></i>
                                <p style="font-size: 1rem; font-weight: 600;">No inspections found</p>
                                <p style="font-size: 0.875rem;">Create a new schedule to begin monitoring.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($inspections as $insp): ?>
                        <tr style="border-bottom: 1px solid var(--border-color-1); transition: background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.01)'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 1.25rem 1.5rem;">
                                <div style="font-weight: 600; color: var(--text-color-1);"><?= htmlspecialchars($insp['business_name']) ?></div>
                                <div style="font-size: 0.75rem; color: var(--text-secondary-1);">ID: #<?= $insp['id'] ?></div>
                            </td>
                            <td style="padding: 1.25rem 1.5rem;">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <div style="width: 24px; height: 24px; background: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 700;">
                                        <?= substr($insp['inspector_name'] ?? 'U', 0, 1) ?>
                                    </div>
                                    <span style="font-size: 0.875rem;"><?= htmlspecialchars($insp['inspector_name'] ?? 'Unassigned') ?></span>
                                </div>
                            </td>
                            <td style="padding: 1.25rem 1.5rem;">
                                <div style="font-size: 0.875rem; font-weight: 500; color: var(--text-color-1);"><?= date('M d, Y', strtotime($insp['scheduled_date'])) ?></div>
                                <div style="font-size: 0.7rem; color: var(--text-secondary-1);"><?= date('h:i A', strtotime($insp['scheduled_date'])) ?></div>
                            </td>
                            <td style="padding: 1.25rem 1.5rem;">
                                <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $insp['status'])) ?>" style="padding: 0.35rem 0.75rem; border-radius: 50px; font-size: 0.75rem; font-weight: 600;">
                                    <?= $insp['status'] ?>
                                </span>
                            </td>
                            <td style="padding: 1.25rem 1.5rem;">
                                <?php if ($insp['rating']): ?>
                                    <div style="font-weight: 700; color: <?= $insp['score'] >= 90 ? '#10b981' : ($insp['score'] >= 75 ? '#f59e0b' : '#ef4444') ?>;">
                                        <?= $insp['rating'] ?> (<?= number_format($insp['score'], 1) ?>%)
                                    </div>
                                <?php else: ?>
                                    <span style="color: #999; font-style: italic; font-size: 0.875rem;">Not Conducted</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 1.25rem 1.5rem; text-align: right;">
                                <?php if ($insp['status'] === 'Scheduled' || $insp['status'] === 'In Progress'): ?>
                                    <a href="/inspections/conduct?id=<?= $insp['id'] ?>" class="btn btn-sm btn-success" style="padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                        <i class="fas fa-play"></i> Conduct
                                    </a>
                                <?php else: ?>
                                    <a href="/inspections/show?id=<?= $insp['id'] ?>" class="btn btn-sm btn-outline-primary" style="padding: 6px 12px; border-radius: 6px; font-weight: 600; border: 1px solid var(--primary-color-1); color: var(--primary-color-1); text-decoration: none;">
                                        <i class="fas fa-file-alt"></i> Report
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
