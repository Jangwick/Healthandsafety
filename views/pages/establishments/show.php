<?php
$contact = json_decode($establishment['contact_json'] ?? '{}', true);
?>
<style>
    .establishment-grid {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 1.5rem;
        align-items: start;
        width: 100%;
    }

    @media (max-width: 1100px) {
        .establishment-grid {
            grid-template-columns: 1fr;
        }
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 1.25rem;
        padding: 0.75rem 0;
        transition: all 0.2s;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: rgba(76, 138, 137, 0.1);
        color: var(--primary-color-1);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 1rem;
    }

    .info-label {
        display: block;
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--text-secondary-1);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .info-value {
        font-weight: 600;
        color: var(--text-color-1);
        font-size: 0.95rem;
        line-height: 1.4;
    }
</style>

<div class="establishment-grid">
    <!-- Left Column: Profile -->
    <div class="left-column">
        <div class="card shadow-sm" style="border-radius: 16px; border: 1px solid var(--border-color-1); background: var(--card-bg-1); overflow: hidden;">
            <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                <h5 style="margin: 0; font-size: 0.95rem; font-weight: 800; color: var(--text-color-1); display: flex; align-items: center; gap: 0.6rem;">
                    <i class="fas fa-building text-primary" style="font-size: 0.85rem;"></i>
                    Profile
                </h5>
                <span class="status-badge status-<?= strtolower($establishment['status']) ?>" style="padding: 0.35rem 0.75rem; border-radius: 50px; font-weight: 800; font-size: 0.65rem; display: inline-flex; align-items: center; gap: 0.4rem; text-transform: uppercase; border: 1px solid transparent;">
                    <i class="fas fa-circle" style="font-size: 6px;"></i>
                    <?= $establishment['status'] ?>
                </span>
            </div>
            <div class="card-body" style="padding: 1.5rem;">

                <!-- Info List -->
                <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-tag"></i></div>
                        <div>
                            <span class="info-label">Business Type</span>
                            <span class="info-value"><?= htmlspecialchars($establishment['type']) ?></span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-user-tie"></i></div>
                        <div>
                            <span class="info-label">Owner / Manager</span>
                            <span class="info-value"><?= htmlspecialchars($contact['owner'] ?? 'N/A') ?></span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9;"><i class="fas fa-phone"></i></div>
                        <div>
                            <span class="info-label">Contact</span>
                            <span class="info-value"><?= htmlspecialchars($contact['phone'] ?? 'N/A') ?></span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <span class="info-label">Location</span>
                            <span class="info-value" style="font-size: 0.85rem;"><?= htmlspecialchars($establishment['location'] ?? 'N/A') ?></span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color-1); display: flex; flex-direction: column; gap: 0.75rem;">
                    <a href="/establishments/edit?id=<?= $establishment['id'] ?>" class="btn btn-outline-secondary" style="width: 100%; justify-content: center; font-weight: 700; border: 1.5px solid var(--border-color-1); border-radius: 10px;">
                        <i class="fas fa-edit"></i> Update Records
                    </a>
                    <a href="/inspections/create?establishment_id=<?= $establishment['id'] ?>" class="btn btn-primary" style="width: 100%; justify-content: center; font-weight: 700; border-radius: 10px; background: var(--primary-color-1); border: none; box-shadow: 0 4px 12px rgba(76, 138, 137, 0.2);">
                        <i class="fas fa-plus"></i> Schedule New Audit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: History -->
    <div class="right-column">
        <div class="card shadow-sm" style="border-radius: 16px; border: 1px solid var(--border-color-1); background: var(--card-bg-1); overflow: hidden;">
            <div class="card-header" style="background: transparent; border-bottom: 1px solid var(--border-color-1); padding: 1.25rem 1.5rem;">
                <h5 style="margin: 0; font-size: 0.95rem; font-weight: 800; color: var(--text-color-1); display: flex; align-items: center; gap: 0.6rem;">
                    <i class="fas fa-history text-primary" style="font-size: 0.85rem;"></i>
                    History
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: rgba(0,0,0,0.02);">
                            <tr>
                                <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase;">Audit Date</th>
                                <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase;">Inspector</th>
                                <th style="padding: 1rem 1.5rem; text-align: center; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase; width: 100px;">Score</th>
                                <th style="padding: 1rem 1.5rem; text-align: center; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase;">Result</th>
                                <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.7rem; font-weight: 700; color: var(--text-secondary-1); text-transform: uppercase;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($history)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="fas fa-clipboard-list fa-3x mb-3 text-secondary opacity-25"></i>
                                            <p class="text-secondary">No inspection history found for this establishment.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($history as $audit): ?>
                                    <tr style="transition: background 0.2s;">
                                        <td style="padding: 1rem 1.5rem; vertical-align: middle;">
                                            <span style="display: block; font-weight: 800; color: var(--text-color-1);"><?= date('M d, Y', strtotime($audit['scheduled_date'])) ?></span>
                                            <span style="font-size: 0.75rem; color: var(--text-secondary-1);"><?= date('h:i A', strtotime($audit['scheduled_date'])) ?></span>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; vertical-align: middle;">
                                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                                <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary-color-1); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.7rem;">
                                                    <?= strtoupper(substr($audit['inspector_name'], 0, 1)) ?>
                                                </div>
                                                <span style="font-weight: 600; font-size: 0.85rem; color: var(--text-color-1);"><?= htmlspecialchars($audit['inspector_name']) ?></span>
                                            </div>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; text-align: center; vertical-align: middle;">
                                            <?php if ($audit['status'] === 'Completed'): ?>
                                                <div style="display: flex; flex-direction: column; align-items: center; gap: 2px;">
                                                    <span style="font-weight: 800; font-size: 1rem; color: <?= $audit['score'] >= 75 ? '#10b981' : '#ef4444' ?>;">
                                                        <?= number_format((float)$audit['score'], 1) ?>%
                                                    </span>
                                                    <div style="width: 50px; height: 4px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
                                                        <div style="width: <?= $audit['score'] ?>%; height: 100%; background: <?= $audit['score'] >= 75 ? '#10b981' : '#ef4444' ?>;"></div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <span style="color: var(--text-secondary-1); font-weight: 800;">--</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; text-align: center; vertical-align: middle;">
                                            <?php
                                                $styles = match($audit['status']) {
                                                    'Completed' => 'background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;',
                                                    'Cancelled' => 'background: #fef2f2; color: #991b1b; border: 1px solid #fecaca;',
                                                    default => 'background: #e0f2fe; color: #075985; border: 1px solid #bae6fd;'
                                                };
                                            ?>
                                            <span style="padding: 0.4rem 0.8rem; border-radius: 50px; font-weight: 800; font-size: 0.65rem; text-transform: uppercase; display: inline-flex; align-items: center; gap: 0.4rem; <?= $styles ?>">
                                                <i class="fas <?= $audit['status'] === 'Completed' ? 'fa-check-circle' : ($audit['status'] === 'Cancelled' ? 'fa-times-circle' : 'fa-clock') ?>"></i>
                                                <?= $audit['status'] ?>
                                            </span>
                                        </td>
                                        <td style="padding: 1rem 1.5rem; text-align: right; vertical-align: middle;">
                                            <a href="/inspections/show?id=<?= $audit['id'] ?>" class="btn btn-outline-secondary" style="padding: 0.4rem 0.8rem; border-radius: 8px; font-size: 0.8rem; font-weight: 700; border: 1.5px solid var(--border-color-1);">
                                                <i class="fas fa-file-alt"></i> View Report
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.detail-icon {
    transition: all 0.3s ease;
}
.detail-item:hover .detail-icon {
    transform: scale(1.1);
    background: var(--primary-color-1) !important;
}
.detail-item:hover .detail-icon i {
    color: white !important;
}
.bg-success-subtle { background-color: rgba(25, 135, 84, 0.1) !important; }
.bg-primary-subtle { background-color: rgba(13, 110, 253, 0.1) !important; }
.bg-danger-subtle { background-color: rgba(220, 53, 69, 0.1) !important; }
.text-success { color: #198754 !important; }
.text-primary { color: #0d6efd !important; }
.text-danger { color: #dc3545 !important; }
.border-success { border-color: rgba(25, 135, 84, 0.2) !important; }
.border-primary { border-color: rgba(13, 110, 253, 0.2) !important; }
.border-danger { border-color: rgba(220, 53, 69, 0.2) !important; }
</style>
