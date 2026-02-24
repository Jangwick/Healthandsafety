<div class="card shadow-sm" style="width: 100%; margin: 0 auto; border-radius: 16px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
    <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.75rem 2rem; display: flex; justify-content: flex-end; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; gap: 0.75rem; align-items: center;">
            <div style="position: relative; width: 280px;">
                <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-secondary-1); font-size: 0.85rem;"></i>
                <input type="text" id="establishmentSearch" placeholder="Filter by business name..." 
                    style="padding: 0.65rem 1rem 0.65rem 2.6rem; border-radius: 10px; border: 1px solid var(--border-color-1); background: var(--bg-color-1); color: var(--text-color-1); width: 100%; font-size: 0.9rem; transition: all 0.2s ease;">
            </div>
            <a href="/establishments/create" class="btn btn-primary" style="padding: 0.7rem 1.25rem; border-radius: 10px; font-weight: 700; font-size: 0.85rem; box-shadow: 0 4px 12px rgba(76, 138, 137, 0.2);">
                <i class="fas fa-plus"></i> Register New
            </a>
        </div>
    </div>
    
    <div class="card-body" style="padding: 0;">
        <?php if (isset($_GET['success'])): ?>
            <div style="margin: 1.5rem 2rem; padding: 1rem; background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 10px; border: 1px solid rgba(16, 185, 129, 0.2); font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>

        <div class="table-container" style="margin: 0; width: 100%; overflow-x: auto;">
            <table class="table table-hover" style="margin-bottom: 0; border-collapse: separate; border-spacing: 0; width: 100% !important; table-layout: fixed;">
                <thead style="background: rgba(var(--header-bg-1-rgb), 0.4);">
                    <tr>
                        <th style="padding: 1.25rem 2rem; border-bottom: 2px solid var(--border-color-1); font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--text-secondary-1); letter-spacing: 0.05em; width: 30%;">Business Identity</th>
                        <th style="padding: 1.25rem 1.5rem; border-bottom: 2px solid var(--border-color-1); font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--text-secondary-1); letter-spacing: 0.05em; width: 15%;">Category</th>
                        <th style="padding: 1.25rem 1.5rem; border-bottom: 2px solid var(--border-color-1); font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--text-secondary-1); letter-spacing: 0.05em; width: 15%;">Registry Status</th>
                        <th style="padding: 1.25rem 1.5rem; border-bottom: 2px solid var(--border-color-1); font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--text-secondary-1); letter-spacing: 0.05em; width: 20%;">Contact Gateway</th>
                        <th style="padding: 1.25rem 2rem; border-bottom: 2px solid var(--border-color-1); font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--text-secondary-1); letter-spacing: 0.05em; text-align: right; width: 20%;">Operations</th>
                    </tr>
                </thead>
                <tbody style="border-top: none;">
                    <?php if (empty($establishments)): ?>
                        <tr>
                            <td colspan="5" style="padding: 6rem 2rem; text-align: center;">
                                <div style="opacity: 0.25;">
                                    <i class="fas fa-store-slash fa-4x mb-4"></i>
                                    <h4 style="font-weight: 800; margin-bottom: 0.5rem;">No Records Detected</h4>
                                    <p style="font-size: 0.9rem; font-weight: 500;">Start population by registering your first business portal.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($establishments as $est): ?>
                        <tr style="transition: all 0.2s ease;">
                            <td style="padding: 1.5rem 2rem; vertical-align: middle;">
                                <div style="font-weight: 800; color: var(--text-color-1); font-size: 1rem; margin-bottom: 0.25rem;"><?= htmlspecialchars($est['name']) ?></div>
                                <div style="font-size: 0.8rem; color: var(--text-secondary-1); display: flex; align-items: center; gap: 6px; font-weight: 500;">
                                    <i class="fas fa-location-dot text-primary" style="font-size: 0.75rem; opacity: 0.8;"></i> 
                                    <?= htmlspecialchars($est['location'] ?? 'Location undefined') ?>
                                </div>
                            </td>
                            <td style="padding: 1.5rem 1.5rem; vertical-align: middle;">
                                <span style="background: rgba(76, 138, 137, 0.08); color: var(--primary-color-1); padding: 0.4rem 0.85rem; border-radius: 8px; font-size: 0.7rem; font-weight: 800; border: 1px solid rgba(76, 138, 137, 0.15); display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fas fa-layer-group" style="font-size: 0.7rem;"></i>
                                    <?= htmlspecialchars($est['type']) ?>
                                </span>
                            </td>
                            <td style="padding: 1.5rem 1.5rem; vertical-align: middle;">
                                <span class="status-badge status-<?= strtolower($est['status']) ?>">
                                    <i class="fas fa-circle"></i>
                                    <?= htmlspecialchars($est['status']) ?>
                                </span>
                            </td>
                            <td style="padding: 1.5rem 1.5rem; vertical-align: middle;">
                                <?php $contact = json_decode($est['contact_json'] ?? '{}', true); ?>
                                <div style="font-size: 0.85rem; color: var(--text-color-1); font-weight: 700; margin-bottom: 0.2rem; display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-phone-volume text-secondary" style="font-size: 0.8rem; opacity: 0.7;"></i>
                                    <?= htmlspecialchars($contact['phone'] ?? 'UNAVAILABLE') ?>
                                </div>
                                <?php if(isset($contact['email']) && !empty($contact['email'])): ?>
                                    <div style="font-size: 0.75rem; color: var(--text-secondary-1); font-weight: 500; display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-envelope-open text-secondary" style="font-size: 0.75rem; opacity: 0.7;"></i>
                                        <?= htmlspecialchars($contact['email']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 1.5rem 2rem; vertical-align: middle; text-align: right;">
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                                    <a href="/establishments/show?id=<?= $est['id'] ?>" class="op-btn" style="background: rgba(76, 138, 137, 0.05); color: var(--primary-color-1);" title="Inspect Data">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/establishments/edit?id=<?= $est['id'] ?>" class="op-btn" style="background: rgba(76, 138, 137, 0.05); color: var(--primary-color-1);" title="Modify Profile">
                                        <i class="fas fa-pen-to-square"></i>
                                    </a>
                                    <a href="/inspections/create?establishment_id=<?= $est['id'] ?>" class="op-btn-primary" title="Initiate Audit">
                                        <i class="fas fa-clipboard-list"></i>
                                    </a>
                                    <a href="/establishments/delete?id=<?= $est['id'] ?>" class="op-btn-danger" onclick="return confirm('Erase this record completely?')" title="Terminate Profile">
                                        <i class="fas fa-trash-can"></i>
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

<style>
.op-btn, .op-btn-primary, .op-btn-danger {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    text-decoration: none;
    border: none;
}
.op-btn:hover { background: var(--primary-color-1) !important; color: white !important; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
.op-btn-primary { background: var(--primary-color-1); color: white; }
.op-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(76,138,137,0.3); background: #3d6f6e; }
.op-btn-danger { background: rgba(239, 68, 68, 0.05); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.1); }
.op-btn-danger:hover { background: #ef4444 !important; color: white !important; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(239,68,68,0.2); }

table tbody tr:hover {
    background: rgba(var(--primary-color-1-rgb, 76, 138, 137), 0.02) !important;
}

#establishmentSearch:focus {
    outline: none;
    border-color: var(--primary-color-1);
    box-shadow: 0 0 0 3px rgba(76, 138, 137, 0.1);
}

table {
    width: 100% !important;
}

th, td {
    white-space: normal;
    word-break: break-word;
}
</style>
