<?php
$contact = json_decode($establishment['contact_json'] ?? '{}', true);
?>
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
            <div class="card-header border-bottom" style="background: transparent; padding: 1.25rem;">
                <h5 class="mb-0" style="font-weight: 700;">Establishment Info</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-secondary small fw-bold text-uppercase">Status</label>
                    <div><span class="status-badge status-<?= strtolower($establishment['status']) ?>"><?= $establishment['status'] ?></span></div>
                </div>
                <div class="mb-3">
                    <label class="text-secondary small fw-bold text-uppercase">Type</label>
                    <div class="text-white"><?= htmlspecialchars($establishment['type']) ?></div>
                </div>
                <div class="mb-3">
                    <label class="text-secondary small fw-bold text-uppercase">Owner</label>
                    <div class="text-white"><?= htmlspecialchars($contact['owner'] ?? 'N/A') ?></div>
                </div>
                <div class="mb-3">
                    <label class="text-secondary small fw-bold text-uppercase">Phone</label>
                    <div class="text-white"><?= htmlspecialchars($contact['phone'] ?? 'N/A') ?></div>
                </div>
                <div class="mb-3">
                    <label class="text-secondary small fw-bold text-uppercase">Email</label>
                    <div class="text-white"><?= htmlspecialchars($contact['email'] ?? 'N/A') ?></div>
                </div>
                <div class="mb-3">
                    <label class="text-secondary small fw-bold text-uppercase">Location</label>
                    <div class="text-white"><?= htmlspecialchars($establishment['location'] ?? 'No address provided') ?></div>
                </div>
                <hr style="border-color: var(--border-color-1);">
                <div class="d-grid gap-2">
                    <a href="/establishments/edit?id=<?= $establishment['id'] ?>" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-edit me-1"></i> Edit Details
                    </a>
                    <a href="/inspections/create?establishment_id=<?= $establishment['id'] ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> New Inspection
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color-1); background: var(--card-bg-1);">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center" style="background: transparent; padding: 1.25rem;">
                <h5 class="mb-0" style="font-weight: 700;">Inspection History</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4">Date</th>
                                <th>Inspector</th>
                                <th>Score</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($history)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-secondary">
                                        <i class="fas fa-history fa-2x mb-2 opacity-25"></i>
                                        <p class="mb-0">No inspections recorded yet.</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($history as $audit): ?>
                                    <tr>
                                        <td class="ps-4"><?= date('M d, Y', strtotime($audit['scheduled_date'])) ?></td>
                                        <td><?= htmlspecialchars($audit['inspector_name']) ?></td>
                                        <td>
                                            <?php if ($audit['status'] === 'Completed'): ?>
                                                <span class="fw-bold <?= $audit['score'] >= 75 ? 'text-success' : 'text-danger' ?>">
                                                    <?= number_format((float)$audit['score'], 1) ?>%
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">--</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill bg-<?= $audit['status'] === 'Completed' ? 'success' : ($audit['status'] === 'Scheduled' ? 'primary' : 'warning') ?>">
                                                <?= $audit['status'] ?>
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="/inspections/show?id=<?= $audit['id'] ?>" class="btn btn-sm btn-link text-decoration-none">View Report</a>
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