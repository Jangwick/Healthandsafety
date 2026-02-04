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

        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Identified Deficiencies</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Requirement</th>
                                <th>Status</th>
                                <th class="pe-4">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($failedItems)): ?>
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">No specific items flagged.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($failedItems as $item): ?>
                                    <tr>
                                        <td class="ps-4"><?= htmlspecialchars($item['requirement_text']) ?></td>
                                        <td><span class="badge bg-danger">Fail</span></td>
                                        <td class="pe-4 text-muted fst-italic"><?= htmlspecialchars($item['notes'] ?? 'No remarks provided') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
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
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($_GET['success']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="text-center mb-4">
                    <h2 class="text-danger">₱<?= number_format((float)$violation['fine_amount'], 2) ?></h2>
                    <span class="badge bg-<?= $violation['status'] === 'Paid' ? 'success' : ($violation['status'] === 'Pending' ? 'danger' : 'warning') ?> p-2 px-4 shadow-sm">
                        <?= $violation['status'] ?>
                    </span>
                </div>
                <hr>
                <div class="d-grid gap-2">
                    <?php if ($violation['status'] === 'Pending'): ?>
                        <form action="/violations/update-status" method="POST">
                            <input type="hidden" name="id" value="<?= $violation['id'] ?>">
                            <input type="hidden" name="status" value="Paid">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check-circle"></i> Mark as Paid
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if ($violation['status'] === 'Paid' || $violation['status'] === 'In Progress'): ?>
                        <form action="/violations/update-status" method="POST">
                            <input type="hidden" name="id" value="<?= $violation['id'] ?>">
                            <input type="hidden" name="status" value="Resolved">
                            <button type="submit" class="btn btn-info w-100 text-white">
                                <i class="fas fa-handshake"></i> Resolve Violation
                            </button>
                        </form>
                    <?php endif; ?>

                    <a href="/violations/print?id=<?= $violation['id'] ?>" target="_blank" class="btn btn-outline-primary">
                        <i class="fas fa-print"></i> Print Citation
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
