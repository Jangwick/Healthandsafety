<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Violation Information</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Establishment:</div>
                    <div class="col-sm-9"><?= htmlspecialchars($violation['establishment_name']) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Location:</div>
                    <div class="col-sm-9"><?= htmlspecialchars($violation['location']) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Description:</div>
                    <div class="col-sm-9 text-danger"><?= nl2br(htmlspecialchars($violation['description'])) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Inspection Score:</div>
                    <div class="col-sm-9"><?= $violation['score'] ?>%</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Inspector:</div>
                    <div class="col-sm-9"><?= htmlspecialchars($violation['inspector_name']) ?></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Penalty Details</h3>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2 class="text-danger">₱<?= number_format((float)$violation['fine_amount'], 2) ?></h2>
                    <span class="badge badge-<?= $violation['status'] === 'Paid' ? 'success' : 'warning' ?> p-2 px-4 shadow-sm">
                        <?= $violation['status'] ?>
                    </span>
                </div>
                <hr>
                <div class="d-grid gap-2">
                    <?php if ($violation['status'] === 'Pending'): ?>
                        <button class="btn btn-success">
                            <i class="fas fa-check-circle"></i> Mark as Paid
                        </button>
                    <?php endif; ?>
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-print"></i> Print Citation
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
