<!-- Statistics Cards -->
<div class="card-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Total Violations -->
    <div class="card shadow-sm" style="padding: 1.25rem; border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between;">
            <div>
                <h3 style="color: var(--text-secondary-1); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Total Violations</h3>
                <p style="color: var(--text-color-1); font-size: 1.75rem; font-weight: 700; line-height: 1; margin: 0;"><?= number_format($stats['total']) ?></p>
            </div>
            <div style="background: rgba(76, 138, 137, 0.1); padding: 10px; border-radius: 10px; color: var(--primary-color-1);">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>

    <!-- Pending -->
    <div class="card shadow-sm" style="padding: 1.25rem; border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between;">
            <div>
                <h3 style="color: var(--text-secondary-1); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Pending</h3>
                <p style="color: #ef4444; font-size: 1.75rem; font-weight: 700; line-height: 1; margin: 0;"><?= number_format($stats['pending']) ?></p>
            </div>
            <div style="background: rgba(239, 68, 68, 0.1); padding: 10px; border-radius: 10px; color: #ef4444;">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <!-- Overdue -->
    <div class="card shadow-sm" style="padding: 1.25rem; border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between;">
            <div>
                <h3 style="color: var(--text-secondary-1); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Overdue</h3>
                <p style="color: #991b1b; font-size: 1.75rem; font-weight: 700; line-height: 1; margin: 0;"><?= number_format($stats['overdue']) ?></p>
            </div>
            <div style="background: rgba(153, 27, 27, 0.1); padding: 10px; border-radius: 10px; color: #991b1b;">
                <i class="fas fa-exclamation-circle"></i>
            </div>
        </div>
    </div>

    <!-- Paid -->
    <div class="card shadow-sm" style="padding: 1.25rem; border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between;">
            <div>
                <h3 style="color: var(--text-secondary-1); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Paid</h3>
                <p style="color: #0ea5e9; font-size: 1.75rem; font-weight: 700; line-height: 1; margin: 0;"><?= number_format($stats['paid']) ?></p>
            </div>
            <div style="background: rgba(14, 165, 233, 0.1); padding: 10px; border-radius: 10px; color: #0ea5e9;">
                <i class="fas fa-receipt"></i>
            </div>
        </div>
    </div>

    <!-- Resolved -->
    <div class="card shadow-sm" style="padding: 1.25rem; border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between;">
            <div>
                <h3 style="color: var(--text-secondary-1); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Resolved</h3>
                <p style="color: #10b981; font-size: 1.75rem; font-weight: 700; line-height: 1; margin: 0;"><?= number_format($stats['resolved']) ?></p>
            </div>
            <div style="background: rgba(16, 185, 129, 0.1); padding: 10px; border-radius: 10px; color: #10b981;">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1); margin-bottom: 2rem; padding: 1.5rem;">
    <form method="GET" action="/violations" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 250px;">
            <label style="display: block; font-size: 0.75rem; font-weight: 600; color: var(--text-secondary-1); text-transform: uppercase; margin-bottom: 0.5rem;">Search Establishment</label>
            <input type="text" name="search" class="form-control" placeholder="Type establishment name..." value="<?= htmlspecialchars($currentSearch ?? '') ?>">
        </div>
        <div style="width: 200px;">
            <label style="display: block; font-size: 0.75rem; font-weight: 600; color: var(--text-secondary-1); text-transform: uppercase; margin-bottom: 0.5rem;">Status</label>
            <select name="status" class="form-control">
                <option value="">All Statuses</option>
                <option value="Pending" <?= ($currentStatus ?? '') === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="In Progress" <?= ($currentStatus ?? '') === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="Paid" <?= ($currentStatus ?? '') === 'Paid' ? 'selected' : '' ?>>Paid</option>
                <option value="Resolved" <?= ($currentStatus ?? '') === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
            </select>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="btn btn-primary" style="height: 48px; display: flex; align-items: center; gap: 0.5rem; padding: 0 1.5rem;">
                <i class="fas fa-filter"></i> Apply Filter
            </button>
            <a href="/violations" class="btn btn-outline-secondary" style="height: 48px; display: flex; align-items: center; justify-content: center; padding: 0 1rem; text-decoration: none; border: 1px solid var(--border-color-1); color: var(--text-color-1);">
                Clear
            </a>
        </div>
    </form>
</div>

<div class="card shadow-sm" style="border-radius: 12px; overflow: hidden; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
    <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; color: var(--text-color-1);">Violation Records</h3>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-container" style="border: none; box-shadow: none;">
            <table class="datatable" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: rgba(0,0,0,0.02);">
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Violation ID</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Establishment</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Description</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Fine Amount</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Status</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Due Date</th>
                        <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($violations ?? [] as $violation): ?>
                        <?php 
                        $isOverdue = (!in_array($violation['status'], ['Paid', 'Resolved'])) && 
                                     ($violation['due_date'] && strtotime($violation['due_date']) < time());
                        ?>
                        <tr style="border-bottom: 1px solid var(--border-color-1); background: <?= $isOverdue ? 'rgba(239, 68, 68, 0.05)' : 'transparent' ?>; transition: background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.01)'" onmouseout="this.style.background='<?= $isOverdue ? 'rgba(239, 68, 68, 0.05)' : 'transparent' ?>'">
                            <td style="padding: 1rem 1.5rem; font-weight: 600;">#<?= $violation['id'] ?></td>
                            <td style="padding: 1rem 1.5rem;">
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-weight: 600; color: var(--text-color-1);"><?= htmlspecialchars($violation['establishment_name']) ?></span>
                                    <small style="color: var(--text-secondary-1); font-size: 0.75rem;">Inspected: <?= date('M d, Y', strtotime($violation['inspection_date'])) ?></small>
                                </div>
                            </td>
                            <td style="padding: 1rem 1.5rem; max-width: 250px;">
                                <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--text-secondary-1); font-size: 0.875rem;" title="<?= htmlspecialchars($violation['description']) ?>">
                                    <?= htmlspecialchars($violation['description']) ?>
                                </div>
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <span style="font-weight: 700; color: #ef4444;">₱<?= number_format((float)$violation['fine_amount'], 2) ?></span>
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <?php
                                $statusStyle = match($violation['status']) {
                                    'Pending' => 'background: #fee2e2; color: #991b1b; border: 1px solid #fecaca;',
                                    'In Progress' => 'background: #fef3c7; color: #92400e; border: 1px solid #fde68a;',
                                    'Paid' => 'background: #e0f2fe; color: #075985; border: 1px solid #bae6fd;',
                                    'Resolved' => 'background: #dcfce7; color: #166534; border: 1px solid #bbf7d0;',
                                    default => 'background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb;'
                                };
                                ?>
                                <div style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; <?= $statusStyle ?>">
                                        <?= $violation['status'] ?>
                                    </span>
                                    <?php if ($isOverdue): ?>
                                        <span style="padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.65rem; font-weight: 700; background: #000; color: #fff;">OVERDUE</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <?php if ($violation['due_date']): ?>
                                    <span style="font-size: 0.875rem; <?= $isOverdue ? 'color: #ef4444; font-weight: 700;' : 'color: var(--text-color-1);' ?>">
                                        <?= date('M d, Y', strtotime($violation['due_date'])) ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color: var(--text-secondary-1); font-size: 0.875rem;">None</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 1rem 1.5rem; text-align: right;">
                                <div style="display: flex; gap: 0.25rem; justify-content: flex-end;">
                                    <a href="/violations/show?id=<?= $violation['id'] ?>" class="btn-icon" title="View Details" style="width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color-1); color: var(--primary-color-1); text-decoration: none;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/violations/print?id=<?= $violation['id'] ?>" target="_blank" class="btn-icon" title="Print Notice" style="width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color-1); color: var(--text-secondary-1); text-decoration: none;">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($violations)): ?>
                        <tr>
                            <td colspan="7" style="padding: 4rem 2rem; text-align: center; color: var(--text-secondary-1);">
                                <div style="opacity: 0.2; margin-bottom: 1rem;">
                                    <i class="fas fa-search fa-4x"></i>
                                </div>
                                <p style="font-size: 1rem; font-weight: 500;">No violation records found</p>
                                <p style="font-size: 0.875rem;">Try adjusting your filters or search terms.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
