<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Audit Summary</h3>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="display-4 fw-bold <?= $inspection['score'] >= 75 ? 'text-success' : 'text-danger' ?>">
                        <?= number_format($inspection['score'], 1) ?>%
                    </div>
                    <div class="h4"><?= $inspection['rating'] ?></div>
                </div>
                <hr>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Status</span>
                        <span class="badge badge-success"><?= $inspection['status'] ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Date</span>
                        <span><?= date('M d, Y', strtotime($inspection['completed_at'])) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Inspector</span>
                        <span><?= htmlspecialchars($inspection['inspector_name']) ?></span>
                    </li>
                </ul>
            </div>
        </div>
        
        <?php if ($inspection['score'] < 75): ?>
            <div class="alert alert-danger shadow-sm border-0">
                <div class="d-flex">
                    <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                    <div>
                        <h5 class="alert-heading">Compliance Alert</h5>
                        <p class="mb-0">This establishment failed the inspection. A violation citation has been automatically generated.</p>
                        <a href="/violations" class="btn btn-sm btn-danger mt-2">View Citation</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-success shadow-sm border-0">
                <div class="d-flex">
                    <i class="fas fa-certificate fa-2x me-3"></i>
                    <div>
                        <h5 class="alert-heading">Compliant</h5>
                        <p class="mb-0">This establishment has passed. A Sanitary Clearance certificate has been issued.</p>
                        <a href="/certificates" class="btn btn-sm btn-success mt-2">View Certificate</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Checklist Results</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Requirement / Regulation</th>
                            <th style="width: 150px;">Result</th>
                            <th style="width: 200px;">Compliance Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $item): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-600" style="font-weight: 600;"><?= htmlspecialchars($item['requirement_text']) ?></div>
                                    <small class="text-muted">ID: #<?= htmlspecialchars($item['checklist_item_id']) ?></small>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $item['result'] === 'Pass' ? 'success' : 'danger' ?>">
                                        <?= $item['result'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($item['result'] === 'Pass'): ?>
                                        <i class="fas fa-check-circle text-success" style="color: #10b981;"></i> Compliant
                                    <?php else: ?>
                                        <i class="fas fa-times-circle text-danger" style="color: #ef4444;"></i> Non-Compliant
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <?php if (!empty($inspection['remarks'])): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Inspector Remarks</h3>
                </div>
                <div class="card-body">
                    <p class="mb-0 italic"><?= nl2br(htmlspecialchars($inspection['remarks'])) ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
