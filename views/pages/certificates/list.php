<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Issued Certificates</h3>
        <button class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Issue New
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>Cert #</th>
                        <th>Establishment</th>
                        <th>Type</th>
                        <th>Issue Date</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($certificates ?? [] as $cert): ?>
                        <tr>
                            <td><strong><?= $cert['certificate_number'] ?></strong></td>
                            <td><?= htmlspecialchars($cert['establishment_name']) ?></td>
                            <td><?= htmlspecialchars($cert['type']) ?></td>
                            <td><?= date('M d, Y', strtotime($cert['issue_date'])) ?></td>
                            <td><?= date('M d, Y', strtotime($cert['expiry_date'])) ?></td>
                            <td>
                                <?php 
                                $isExpired = strtotime($cert['expiry_date']) < time();
                                ?>
                                <span class="badge badge-<?= $isExpired ? 'secondary' : 'success' ?>">
                                    <?= $isExpired ? 'Expired' : 'Active' ?>
                                </span>
                            </td>
                            <td>
                                <a href="/certificates/show?id=<?= $cert['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-print"></i> Print
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
