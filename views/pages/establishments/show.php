<?php
$contact = json_decode($establishment['contact_json'] ?? '{}', true);
?>
<div class="row">
    <!-- Establishment Details Card -->
    <div class="col-lg-4 col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <i class="fas fa-info-circle me-2 text-primary"></i>
                <h5 class="mb-0" style="font-weight: 700;">Establishment Details</h5>
            </div>
            <div class="card-body">
                <div class="detail-container">
                    <!-- Status -->
                    <div class="detail-item mb-4">
                        <label class="text-secondary small fw-bold text-uppercase d-block mb-1">Current Status</label>
                        <span class="status-badge status-<?= strtolower($establishment['status']) ?>" style="padding: 0.5rem 1rem; border-radius: 50px; font-weight: 600; font-size: 0.85rem;">
                            <i class="fas fa-circle me-1" style="font-size: 8px; vertical-align: middle;"></i>
                            <?= $establishment['status'] ?>
                        </span>
                    </div>

                    <!-- Grid for Info -->
                    <div class="row g-3">
                        <div class="col-12 mb-2">
                            <div class="d-flex align-items-start">
                                <span class="detail-icon bg-light rounded-circle p-2 me-3" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-tag text-primary small"></i>
                                </span>
                                <div>
                                    <label class="text-secondary small fw-bold text-uppercase d-block">Business Type</label>
                                    <span class="fw-medium text-color-1"><?= htmlspecialchars($establishment['type']) ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            <div class="d-flex align-items-start">
                                <span class="detail-icon bg-light rounded-circle p-2 me-3" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user-tie text-primary small"></i>
                                </span>
                                <div>
                                    <label class="text-secondary small fw-bold text-uppercase d-block">Owner / Manager</label>
                                    <span class="fw-medium text-color-1"><?= htmlspecialchars($contact['owner'] ?? 'N/A') ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            <div class="d-flex align-items-start">
                                <span class="detail-icon bg-light rounded-circle p-2 me-3" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-phone text-primary small"></i>
                                </span>
                                <div>
                                    <label class="text-secondary small fw-bold text-uppercase d-block">Contact Number</label>
                                    <span class="fw-medium text-color-1"><?= htmlspecialchars($contact['phone'] ?? 'N/A') ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            <div class="d-flex align-items-start">
                                <span class="detail-icon bg-light rounded-circle p-2 me-3" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-envelope text-primary small"></i>
                                </span>
                                <div>
                                    <label class="text-secondary small fw-bold text-uppercase d-block">Email Address</label>
                                    <span class="fw-medium text-color-1"><?= htmlspecialchars($contact['email'] ?? 'N/A') ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <span class="detail-icon bg-light rounded-circle p-2 me-3" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-map-marker-alt text-primary small"></i>
                                </span>
                                <div>
                                    <label class="text-secondary small fw-bold text-uppercase d-block">Full Address</label>
                                    <span class="fw-medium text-color-1"><?= htmlspecialchars($establishment['location'] ?? 'No address provided') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-top">
                    <div class="d-flex flex-column gap-2">
                        <a href="/establishments/edit?id=<?= $establishment['id'] ?>" class="btn btn-secondary w-100 justify-content-center">
                            <i class="fas fa-edit"></i> Update Records
                        </a>
                        <a href="/inspections/create?establishment_id=<?= $establishment['id'] ?>" class="btn btn-primary w-100 justify-content-center">
                            <i class="fas fa-plus"></i> Schedule New Audit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inspection History Table Card -->
    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas fa-history me-2 text-primary"></i>
                    <h5 class="mb-0" style="font-weight: 700;">Audit & Inspection History</h5>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: rgba(0,0,0,0.02);">
                            <tr>
                                <th class="ps-4 border-0 py-3 text-secondary small fw-bold text-uppercase">Audit Date</th>
                                <th class="border-0 py-3 text-secondary small fw-bold text-uppercase">Assigned Inspector</th>
                                <th class="border-0 py-3 text-secondary small fw-bold text-uppercase">Score</th>
                                <th class="border-0 py-3 text-secondary small fw-bold text-uppercase">Result</th>
                                <th class="text-end pe-4 border-0 py-3 text-secondary small fw-bold text-uppercase">Report</th>
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
                                        <td class="ps-4 py-3 align-middle">
                                            <span class="d-block fw-bold"><?= date('M d, Y', strtotime($audit['scheduled_date'])) ?></span>
                                            <span class="text-secondary small"><?= date('h:i A', strtotime($audit['scheduled_date'])) ?></span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 24px; height: 24px; font-size: 10px;">
                                                    <?= strtoupper(substr($audit['inspector_name'], 0, 1)) ?>
                                                </div>
                                                <span class="fw-medium"><?= htmlspecialchars($audit['inspector_name']) ?></span>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <?php if ($audit['status'] === 'Completed'): ?>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold <?= $audit['score'] >= 75 ? 'text-success' : 'text-danger' ?>" style="font-size: 1.1rem;">
                                                        <?= number_format((float)$audit['score'], 1) ?>%
                                                    </span>
                                                    <div class="progress mt-1" style="height: 4px; width: 60px; background: rgba(0,0,0,0.05);">
                                                        <div class="progress-bar <?= $audit['score'] >= 75 ? 'bg-success' : 'bg-danger' ?>" style="width: <?= $audit['score'] ?>%"></div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-secondary">--</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php
                                                $statusColor = 'primary';
                                                $statusIcon = 'clock';
                                                if ($audit['status'] === 'Completed') {
                                                    $statusColor = 'success';
                                                    $statusIcon = 'check-circle';
                                                } elseif ($audit['status'] === 'Cancelled') {
                                                    $statusColor = 'danger';
                                                    $statusIcon = 'times-circle';
                                                }
                                            ?>
                                            <span class="badge rounded-pill bg-<?= $statusColor ?>-subtle text-<?= $statusColor ?> border border-<?= $statusColor ?> px-3 py-2" style="font-size: 0.75rem;">
                                                <i class="fas fa-<?= $statusIcon ?> me-1"></i>
                                                <?= $audit['status'] ?>
                                            </span>
                                        </td>
                                        <td class="text-end pe-4 align-middle">
                                            <a href="/inspections/show?id=<?= $audit['id'] ?>" class="btn btn-sm btn-outline-primary" style="padding: 0.4rem 0.8rem; border-radius: 6px;">
                                                <i class="fas fa-file-alt me-1"></i> View Report
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
