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
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success m-3"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger m-3"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

        <div class="table-container" style="border: none; box-shadow: none; margin: 0;">
            <table class="table table-hover mb-0">
                <thead style="background: rgba(0,0,0,0.02);">
                    <tr>
                        <th style="padding: 1.25rem 1.5rem; border: 0; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--text-secondary-1);">Business Details</th>
                        <th style="padding: 1.25rem 1.5rem; border: 0; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--text-secondary-1);">Type / Category</th>
                        <th style="padding: 1.25rem 1.5rem; border: 0; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--text-secondary-1);">Status</th>
                        <th style="padding: 1.25rem 1.5rem; border: 0; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--text-secondary-1);">Contact Info</th>
                        <th style="padding: 1.25rem 1.5rem; border: 0; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--text-secondary-1); text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($establishments)): ?>
                        <tr>
                            <td colspan="5" style="padding: 5rem 2rem; text-align: center;">
                                <div style="opacity: 0.3;">
                                    <i class="fas fa-store-slash fa-4x mb-3"></i>
                                    <p style="font-size: 1.1rem; font-weight: 600; margin: 0;">No establishments found</p>
                                    <p style="font-size: 0.9rem;">Register your first business establishment to get started.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($establishments as $est): ?>
                        <tr style="transition: all 0.2s;">
                            <td style="padding: 1.25rem 1.5rem; vertical-align: middle;">
                                <div style="font-weight: 700; color: var(--text-color-1); font-size: 1rem; margin-bottom: 2px;"><?= htmlspecialchars($est['name']) ?></div>
                                <div style="font-size: 0.8rem; color: var(--text-secondary-1); display: flex; align-items: center; gap: 5px;">
                                    <i class="fas fa-map-marker-alt text-primary" style="font-size: 10px;"></i> 
                                    <?= htmlspecialchars($est['location'] ?? 'No address') ?>
                                </div>
                            </td>
                            <td style="padding: 1.25rem 1.5rem; vertical-align: middle;">
                                <span style="background: rgba(76, 138, 137, 0.1); color: var(--primary-color-1); padding: 5px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; border: 1px solid rgba(76, 138, 137, 0.2);">
                                    <i class="fas fa-tag me-1" style="font-size: 10px;"></i>
                                    <?= htmlspecialchars($est['type']) ?>
                                </span>
                            </td>
                            <td style="padding: 1.25rem 1.5rem; vertical-align: middle;">
                                <span class="status-badge status-<?= strtolower($est['status']) ?>">
                                    <i class="fas fa-circle me-1" style="font-size: 6px;"></i>
                                    <?= htmlspecialchars($est['status']) ?>
                                </span>
                            </td>
                            <td style="padding: 1.25rem 1.5rem; vertical-align: middle;">
                                <?php $contact = json_decode($est['contact_json'] ?? '{}', true); ?>
                                <div style="font-size: 0.85rem; color: var(--text-color-1); font-weight: 500;">
                                    <i class="fas fa-phone-alt text-secondary" style="width: 14px; margin-right: 8px;"></i><?= htmlspecialchars($contact['phone'] ?? 'N/A') ?>
                                </div>
                                <?php if(isset($contact['email'])): ?>
                                    <div style="font-size: 0.75rem; color: var(--text-secondary-1); margin-top: 2px;">
                                        <i class="fas fa-envelope text-secondary" style="width: 14px; margin-right: 8px;"></i><?= htmlspecialchars($contact['email']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 1.25rem 1.5rem; vertical-align: middle; text-align: right;">
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <a href="/establishments/show?id=<?= $est['id'] ?>" class="btn btn-sm btn-secondary" style="padding: 0.5rem 0.75rem; border-radius: 6px;" title="View Details">
                                        <i class="fas fa-eye text-primary"></i>
                                    </a>
                                    <a href="/establishments/edit?id=<?= $est['id'] ?>" class="btn btn-sm btn-secondary" style="padding: 0.5rem 0.75rem; border-radius: 6px;" title="Edit Establishment">
                                        <i class="fas fa-edit text-primary"></i>
                                    </a>
                                    <a href="/inspections/create?establishment_id=<?= $est['id'] ?>" class="btn btn-sm btn-primary" style="padding: 0.5rem 0.75rem; border-radius: 6px;" title="Schedule Inspection">
                                        <i class="fas fa-clipboard-check"></i>
                                    </a>
                                    <a href="/establishments/delete?id=<?= $est['id'] ?>" class="btn btn-sm btn-outline-danger" style="padding: 0.5rem 0.75rem; border-radius: 6px;" onclick="return confirm('Are you sure you want to delete this establishment?')" title="Delete">
                                        <i class="fas fa-trash"></i>
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
