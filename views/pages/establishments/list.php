<div class="card shadow-sm" style="border-radius: 12px; overflow: hidden; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
    <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-color-1);">Registered Establishments</h3>
            <p style="margin: 0.25rem 0 0; font-size: 0.875rem; color: var(--text-secondary-1);">Manage and view all businesses in the jurisdiction</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <div style="position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1);"></i>
                <input type="text" id="establishmentSearch" placeholder="Search businesses..." 
                    style="padding: 0.6rem 1rem 0.6rem 2.5rem; border-radius: 8px; border: 1px solid var(--border-color-1); background: var(--bg-color-1); color: var(--text-color-1); width: 250px;">
            </div>
            <a href="/establishments/create" class="btn btn-primary" style="display: flex; align-items: center; gap: 0.5rem; background: var(--primary-color-1); border: none; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 600;">
                <i class="fas fa-plus"></i> Register New
            </a>
        </div>
    </div>
    
    <div class="card-body" style="padding: 0;">
        <div class="table-container" style="border: none; box-shadow: none; margin: 0;">
            <table class="datatable" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: rgba(0,0,0,0.02);">
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Business Details</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Type / Category</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Current Status</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Contact Info</th>
                        <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-secondary-1); border-bottom: 2px solid var(--border-color-1);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($establishments)): ?>
                        <tr>
                            <td colspan="5" style="padding: 4rem 2rem; text-align: center; color: var(--text-secondary-1);">
                                <i class="fas fa-store-slash fa-4x" style="opacity: 0.2; margin-bottom: 1rem;"></i>
                                <p style="font-size: 1rem; font-weight: 600;">No establishments found</p>
                                <p style="font-size: 0.875rem;">Try adding your first business establishment.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($establishments as $est): ?>
                        <tr style="border-bottom: 1px solid var(--border-color-1); transition: background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.01)'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 1.25rem 1.5rem;">
                                <div style="font-weight: 600; color: var(--text-color-1); font-size: 1rem;"><?= htmlspecialchars($est['name']) ?></div>
                                <div style="font-size: 0.8rem; color: var(--text-secondary-1);"><i class="fas fa-map-marker-alt" style="margin-right: 4px;"></i> <?= htmlspecialchars($est['location'] ?? 'No address') ?></div>
                            </td>
                            <td style="padding: 1.25rem 1.5rem;">
                                <span style="background: rgba(76, 138, 137, 0.1); color: var(--primary-color-1); padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                                    <?= htmlspecialchars($est['type']) ?>
                                </span>
                            </td>
                            <td style="padding: 1.25rem 1.5rem;">
                                <span class="status-badge status-<?= strtolower($est['status']) ?>" style="padding: 0.35rem 0.75rem; border-radius: 50px; font-size: 0.75rem; font-weight: 600;">
                                    <?= htmlspecialchars($est['status']) ?>
                                </span>
                            </td>
                            <td style="padding: 1.25rem 1.5rem; color: var(--text-secondary-1);">
                                <?php 
                                    $contact = json_decode($est['contact_json'] ?? '{}', true);
                                    echo '<div style="font-size: 0.875rem;"><i class="fas fa-phone-alt" style="width: 16px; margin-right: 6px;"></i>'.htmlspecialchars($contact['phone'] ?? 'N/A').'</div>';
                                    if(isset($contact['email'])) echo '<div style="font-size: 0.75rem;"><i class="fas fa-envelope" style="width: 16px; margin-right: 6px;"></i>'.htmlspecialchars($contact['email']).'</div>';
                                ?>
                            </td>
                            <td style="padding: 1.25rem 1.5rem; text-align: right;">
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <a href="/establishments/show?id=<?= $est['id'] ?>" class="btn btn-sm" style="background: rgba(0,0,0,0.05); color: var(--text-color-1); border: none; padding: 6px 12px; border-radius: 6px; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.1)'" onmouseout="this.style.background='rgba(0,0,0,0.05)'">
                                        <i class="fas fa-eye"></i> Details
                                    </a>
                                    <a href="/inspections/create?establishment_id=<?= $est['id'] ?>" class="btn btn-sm btn-success" style="padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                        <i class="fas fa-clipboard-check"></i> Inspect
                                    </a>
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
