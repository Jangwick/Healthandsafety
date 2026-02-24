<?php
$contact = json_decode($establishment['contact_json'] ?? '{}', true);

// Calculate some quick stats from history for the UI
$totalInspections = count($history);
$completedInspections = array_filter($history, fn($h) => $h['status'] === 'Completed');
$avgScore = count($completedInspections) > 0 
    ? array_sum(array_map(fn($h) => $h['score'], $completedInspections)) / count($completedInspections) 
    : 0;
$latestResult = !empty($history) ? $history[0] : null;
?>

<div class="establishment-view-container">
    <!-- Header Section with Stats -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, var(--primary-color-1) 0%, var(--secondary-color-1) 100%); border-radius: 16px;">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-2" style="--bs-breadcrumb-divider-color: rgba(255,255,255,0.7);">
                                    <li class="breadcrumb-item"><a href="/establishments" class="text-white-50 text-decoration-none">Establishments</a></li>
                                    <li class="breadcrumb-item active text-white" aria-current="page">View Details</li>
                                </ol>
                            </nav>
                            <h2 class="fw-bold mb-0"><?= htmlspecialchars($establishment['name']) ?></h2>
                            <p class="opacity-75 mb-0"><i class="fas fa-map-marker-alt me-1"></i> <?= htmlspecialchars($establishment['location'] ?? 'Location not specified') ?></p>
                        </div>
                        <div class="d-flex gap-4 text-center">
                            <div class="stat-item">
                                <div class="h4 fw-bold mb-0"><?= $totalInspections ?></div>
                                <div class="small opacity-75 text-uppercase fw-bold" style="font-size: 0.65rem;">Total Audits</div>
                            </div>
                            <div class="stat-item" style="border-left: 1px solid rgba(255,255,255,0.2); padding-left: 1.5rem;">
                                <div class="h4 fw-bold mb-0"><?= number_format($avgScore, 1) ?>%</div>
                                <div class="small opacity-75 text-uppercase fw-bold" style="font-size: 0.65rem;">Avg Score</div>
                            </div>
                            <div class="stat-item" style="border-left: 1px solid rgba(255,255,255,0.2); padding-left: 1.5rem;">
                                <div class="h4 fw-bold mb-0"><?= $establishment['type'] ?></div>
                                <div class="small opacity-75 text-uppercase fw-bold" style="font-size: 0.65rem;">Category</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar: Establishment Info -->
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Business Profile</h5>
                </div>
                <div class="card-body px-4">
                    <div class="info-list">
                        <!-- Status Section -->
                        <div class="info-group mb-4">
                            <label class="text-secondary small fw-bold text-uppercase d-block mb-2">Registration Status</label>
                            <span class="status-badge status-<?= strtolower($establishment['status']) ?>" style="padding: 0.5rem 1.25rem; font-size: 0.85rem;">
                                <i class="fas fa-circle me-2" style="font-size: 8px;"></i> <?= $establishment['status'] ?>
                            </span>
                        </div>

                        <!-- Details Grid -->
                        <div class="info-item mb-4">
                            <div class="d-flex align-items-center mb-1">
                                <i class="fas fa-user-circle text-primary me-2"></i>
                                <span class="text-secondary small fw-bold text-uppercase">Owner / Representative</span>
                            </div>
                            <div class="fw-medium ps-4"><?= htmlspecialchars($contact['owner'] ?? 'Not set') ?></div>
                        </div>

                        <div class="info-item mb-4">
                            <div class="d-flex align-items-center mb-1">
                                <i class="fas fa-phone-alt text-primary me-2"></i>
                                <span class="text-secondary small fw-bold text-uppercase">Direct Contact</span>
                            </div>
                            <div class="fw-medium ps-4"><?= htmlspecialchars($contact['phone'] ?? 'N/A') ?></div>
                        </div>

                        <div class="info-item mb-4">
                            <div class="d-flex align-items-center mb-1">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <span class="text-secondary small fw-bold text-uppercase">Email Address</span>
                            </div>
                            <div class="fw-medium ps-4 text-break"><?= htmlspecialchars($contact['email'] ?? 'Not provided') ?></div>
                        </div>

                        <div class="info-item mb-4">
                            <div class="d-flex align-items-center mb-1">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <span class="text-secondary small fw-bold text-uppercase">Last Activity</span>
                            </div>
                            <div class="fw-medium ps-4">
                                <?= $latestResult ? date('M d, Y', strtotime($latestResult['scheduled_date'])) : 'No history yet' ?>
                            </div>
                        </div>
                    </div>

                    <div class="action-buttons mt-5 pt-4 border-top d-grid gap-2">
                        <a href="/establishments/edit?id=<?= $establishment['id'] ?>" class="btn btn-outline-primary py-2 fw-bold">
                            <i class="fas fa-edit me-2"></i> Edit Profile
                        </a>
                        <a href="/inspections/create?establishment_id=<?= $establishment['id'] ?>" class="btn btn-primary py-2 fw-bold shadow-sm">
                            <i class="fas fa-plus me-2"></i> Schedule Audit
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content: Audit History -->
        <div class="col-lg-8 col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Audit History</h5>
                    <button class="btn btn-sm btn-light" title="Export History">
                        <i class="fas fa-download text-secondary"></i>
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="auditHistoryTable">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0 text-secondary small fw-bold text-uppercase" style="width: 25%;">Audit Date</th>
                                    <th class="py-3 border-0 text-secondary small fw-bold text-uppercase" style="width: 30%;">Inspector</th>
                                    <th class="py-3 border-0 text-secondary small fw-bold text-uppercase" style="width: 15%;">Score</th>
                                    <th class="py-3 border-0 text-secondary small fw-bold text-uppercase" style="width: 15%;">Result</th>
                                    <th class="text-end pe-4 py-3 border-0 text-secondary small fw-bold text-uppercase" style="width: 15%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($history)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="py-4">
                                                <div class="empty-state-icon mb-3">
                                                    <i class="fas fa-folder-open fa-3x text-light"></i>
                                                </div>
                                                <h6 class="text-secondary fw-bold">No Audit Records Found</h6>
                                                <p class="text-muted small">This establishment has not been inspected yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($history as $audit): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold"><?= date('M d, Y', strtotime($audit['scheduled_date'])) ?></div>
                                                <div class="text-muted extra-small"><?= date('h:i A', strtotime($audit['scheduled_date'])) ?></div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-primary-subtle text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                                        <?= strtoupper(substr($audit['inspector_name'], 0, 1)) ?>
                                                    </div>
                                                    <div class="fw-medium text-truncate" style="max-width: 150px;" title="<?= htmlspecialchars($audit['inspector_name']) ?>">
                                                        <?= htmlspecialchars($audit['inspector_name']) ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($audit['status'] === 'Completed'): ?>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-bold <?= $audit['score'] >= 75 ? 'text-success' : 'text-danger' ?>">
                                                            <?= number_format((float)$audit['score'], 1) ?>%
                                                        </span>
                                                        <div class="progress" style="height: 3px; width: 40px;">
                                                            <div class="progress-bar <?= $audit['score'] >= 75 ? 'bg-success' : 'bg-danger' ?>" style="width: <?= $audit['score'] ?>%"></div>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted small">Pending</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="status-badge status-<?= strtolower($audit['status']) ?>" style="padding: 0.25rem 0.75rem; font-size: 0.7rem;">
                                                    <?= $audit['status'] ?>
                                                </span>
                                            </td>
                                            <td class="text-end pe-4 text-nowrap">
                                                <a href="/inspections/show?id=<?= $audit['id'] ?>" class="btn btn-link btn-sm text-primary p-0">
                                                    <i class="fas fa-arrow-right"></i>
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
</div>

<style>
.establishment-view-container {
    padding: 1rem 0;
}
.stat-item {
    min-width: 80px;
}
.info-item i {
    width: 20px;
}
.extra-small {
    font-size: 0.7rem;
}
.bg-primary-subtle {
    background-color: rgba(13, 110, 253, 0.1) !important;
}
.text-truncate {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
#auditHistoryTable th {
    white-space: nowrap;
}
#auditHistoryTable td {
    border-color: rgba(0,0,0,0.03);
    padding-top: 1rem;
    padding-bottom: 1rem;
}
.empty-state-icon {
    width: 80px;
    height: 80px;
    background: rgba(0,0,0,0.02);
    border-radius: 50%;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
}
.avatar-sm {
    flex-shrink: 0;
}
@media (max-width: 991px) {
    .stat-item {
        border-left: none !important;
        padding-left: 0 !important;
    }
}
</style>

