<!-- Statistics Section -->
<div class="card-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
    <!-- Active Certificates -->
    <div class="card shadow-sm" style="padding: 1.5rem; border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between;">
            <div>
                <h3 style="color: var(--text-secondary-1); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Valid Permits</h3>
                <p style="color: #10b981; font-size: 1.75rem; font-weight: 700; line-height: 1; margin: 0;"><?= number_format($stats['active']) ?></p>
            </div>
            <div style="background: rgba(16, 185, 129, 0.1); padding: 10px; border-radius: 10px; color: #10b981;">
                <i class="fas fa-certificate fa-lg"></i>
            </div>
        </div>
    </div>

    <!-- Total Issued -->
    <div class="card shadow-sm" style="padding: 1.5rem; border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between;">
            <div>
                <h3 style="color: var(--text-secondary-1); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Total Issued</h3>
                <p style="color: var(--text-color-1); font-size: 1.75rem; font-weight: 700; line-height: 1; margin: 0;"><?= number_format($stats['total']) ?></p>
            </div>
            <div style="background: rgba(76, 138, 137, 0.1); padding: 10px; border-radius: 10px; color: var(--primary-color-1);">
                <i class="fas fa-file-invoice fa-lg"></i>
            </div>
        </div>
    </div>

    <!-- Expired -->
    <div class="card shadow-sm" style="padding: 1.5rem; border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between;">
            <div>
                <h3 style="color: var(--text-secondary-1); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Expired</h3>
                <p style="color: #6b7280; font-size: 1.75rem; font-weight: 700; line-height: 1; margin: 0;"><?= number_format($stats['expired']) ?></p>
            </div>
            <div style="background: rgba(107, 114, 128, 0.1); padding: 10px; border-radius: 10px; color: #6b7280;">
                <i class="fas fa-hourglass-end fa-lg"></i>
            </div>
        </div>
    </div>

    <!-- Revoked -->
    <div class="card shadow-sm" style="padding: 1.5rem; border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between;">
            <div>
                <h3 style="color: var(--text-secondary-1); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Revoked</h3>
                <p style="color: #ef4444; font-size: 1.75rem; font-weight: 700; line-height: 1; margin: 0;"><?= number_format($stats['revoked']) ?></p>
            </div>
            <div style="background: rgba(239, 68, 68, 0.1); padding: 10px; border-radius: 10px; color: #ef4444;">
                <i class="fas fa-ban fa-lg"></i>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter Bar -->
<div class="card shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1); margin-bottom: 2rem; padding: 1.5rem;">
    <form method="GET" action="/certificates" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 280px;">
            <label style="display: block; font-size: 0.75rem; font-weight: 600; color: var(--text-secondary-1); text-transform: uppercase; margin-bottom: 0.5rem;">Search Certificate or Establishment</label>
            <input type="text" name="search" class="form-control" placeholder="Type name or cert number..." value="<?= htmlspecialchars($currentSearch ?? '') ?>">
        </div>
        <div style="width: 200px;">
            <label style="display: block; font-size: 0.75rem; font-weight: 600; color: var(--text-secondary-1); text-transform: uppercase; margin-bottom: 0.5rem;">Status</label>
            <select name="status" class="form-control">
                <option value="">All Statuses</option>
                <option value="Valid" <?= ($currentStatus ?? '') === 'Valid' ? 'selected' : '' ?>>Valid</option>
                <option value="Expired" <?= ($currentStatus ?? '') === 'Expired' ? 'selected' : '' ?>>Expired</option>
                <option value="Revoked" <?= ($currentStatus ?? '') === 'Revoked' ? 'selected' : '' ?>>Revoked</option>
            </select>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="btn btn-primary" style="height: 48px; border-radius: 8px; padding: 0 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-search"></i> Find Records
            </button>
            <a href="/certificates" class="btn btn-outline-secondary" style="height: 48px; border-radius: 8px; padding: 0 1.25rem; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid var(--border-color-1); color: var(--text-color-1);">
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Main Records Table -->
<div class="card shadow-sm" style="border-radius: 12px; overflow: hidden; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
    <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; color: var(--text-color-1);">Permit Log</h3>
        <a href="/certificates/create" class="btn btn-primary" style="padding: 0.6rem 1.2rem; border-radius: 8px; font-size: 0.875rem; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(76, 138, 137, 0.2);">
            <i class="fas fa-plus"></i> Manual Issue
        </a>
    </div>
    <div class="card-body" style="padding: 0;">
        <?php if (isset($_GET['success'])): ?>
            <div style="margin: 1rem 1.5rem; padding: 0.75rem 1.25rem; background: #dcfce7; color: #166534; border-radius: 8px; border: 1px solid #bbf7d0; display: flex; align-items: center; gap: 0.75rem; font-size: 0.875rem;">
                <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div style="margin: 1rem 1.5rem; padding: 0.75rem 1.25rem; background: #fee2e2; color: #991b1b; border-radius: 8px; border: 1px solid #fecaca; display: flex; align-items: center; gap: 0.75rem; font-size: 0.875rem;">
                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <div class="table-container" style="border: none; box-shadow: none;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: rgba(0,0,0,0.01);">
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; border-bottom: 1px solid var(--border-color-1);">Certificate Number</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; border-bottom: 1px solid var(--border-color-1);">Establishment</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; border-bottom: 1px solid var(--border-color-1);">Type</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; border-bottom: 1px solid var(--border-color-1);">Issue / Expiry</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; border-bottom: 1px solid var(--border-color-1);">Status</th>
                        <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; border-bottom: 1px solid var(--border-color-1);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($certificates)): ?>
                        <tr>
                            <td colspan="6" style="padding: 4rem; text-align: center; color: var(--text-secondary-1);">
                                <i class="fas fa-certificate fa-3x" style="opacity: 0.1; margin-bottom: 1rem; display: block;"></i>
                                <p style="margin: 0; font-weight: 600;">No certificates found matching your criteria.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($certificates as $cert): ?>
                            <?php 
                            $isExpired = strtotime($cert['expiry_date']) < time();
                            $effectiveStatus = $cert['status'];
                            if ($isExpired && $effectiveStatus === 'Valid') $effectiveStatus = 'Expired';
                            
                            $statusStyle = match($effectiveStatus) {
                                'Valid' => 'background: #dcfce7; color: #166534; border: 1px solid #bbf7d0;',
                                'Expired' => 'background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb;',
                                'Revoked' => 'background: #fee2e2; color: #991b1b; border: 1px solid #fecaca;',
                                default => 'background: #e0f2fe; color: #075985; border: 1px solid #bae6fd;'
                            };
                            ?>
                            <tr style="border-bottom: 1px solid var(--border-color-1); transition: background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.01)'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 1.25rem 1.5rem;">
                                    <div style="font-weight: 700; color: var(--text-color-1); font-size: 0.9375rem;"><?= $cert['certificate_number'] ?></div>
                                    <small style="color: var(--text-secondary-1);">ID: #<?= $cert['id'] ?></small>
                                </td>
                                <td style="padding: 1.25rem 1.5rem;">
                                    <div style="font-weight: 600; color: var(--text-color-1);"><?= htmlspecialchars($cert['establishment_name']) ?></div>
                                </td>
                                <td style="padding: 1.25rem 1.5rem;">
                                    <span style="font-size: 0.8125rem; color: var(--text-secondary-1);"><?= htmlspecialchars($cert['type']) ?></span>
                                </td>
                                <td style="padding: 1.25rem 1.5rem;">
                                    <div style="font-size: 0.8125rem; font-weight: 600; color: var(--text-color-1);"><?= date('M d, Y', strtotime($cert['issue_date'])) ?></div>
                                    <div style="font-size: 0.75rem; color: <?= $isExpired ? '#ef4444' : 'var(--text-secondary-1)' ?>;"><?= date('M d, Y', strtotime($cert['expiry_date'])) ?> <?= $isExpired ? '(Expired)' : '' ?></div>
                                </td>
                                <td style="padding: 1.25rem 1.5rem;">
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; <?= $statusStyle ?>">
                                        <?= $effectiveStatus ?>
                                    </span>
                                </td>
                                <td style="padding: 1.25rem 1.5rem; text-align: right;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                        <a href="/certificates/show?id=<?= $cert['id'] ?>" class="btn-icon" title="View & Print" style="width: 36px; height: 36px; border-radius: 8px; border: 1px solid var(--border-color-1); display: flex; align-items: center; justify-content: center; color: var(--primary-color-1); text-decoration: none;">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <?php if ($cert['status'] === 'Valid' && !$isExpired): ?>
                                            <form action="/certificates/revoke" method="POST" style="margin: 0;" onsubmit="return confirm('REVOKE this certificate? This cannot be undone.')">
                                                <input type="hidden" name="id" value="<?= $cert['id'] ?>">
                                                <button type="submit" class="btn-icon" title="Revoke Certificate" style="width: 36px; height: 36px; border-radius: 8px; border: 1px solid var(--border-color-1); display: flex; align-items: center; justify-content: center; color: #f59e0b; background: transparent; cursor: pointer;">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <form action="/certificates/delete" method="POST" style="margin: 0;" onsubmit="return confirm('DELETE this recordPermanently? This will remove it from the history.')">
                                            <input type="hidden" name="id" value="<?= $cert['id'] ?>">
                                            <button type="submit" class="btn-icon" title="Delete Record" style="width: 36px; height: 36px; border-radius: 8px; border: 1px solid var(--border-color-1); display: flex; align-items: center; justify-content: center; color: #ef4444; background: transparent; cursor: pointer;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
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
