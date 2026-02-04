<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Issued Certificates</h3>
    </div>
    <div class="card-body">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

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
                                $status = $cert['status'];
                                if ($isExpired && $status === 'Valid') $status = 'Expired';
                                
                                $badgeClass = match($status) {
                                    'Valid' => 'success',
                                    'Expired' => 'secondary',
                                    'Revoked' => 'danger',
                                    default => 'info'
                                };
                                ?>
                                <span class="badge bg-<?= $badgeClass ?>">
                                    <?= $status ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="/certificates/show?id=<?= $cert['id'] ?>" class="btn btn-sm btn-outline-primary" title="Print/View">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <?php if ($cert['status'] === 'Valid' && !$isExpired): ?>
                                        <form action="/certificates/revoke" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to REVOKE this certificate? This action cannot be undone.')">
                                            <input type="hidden" name="id" value="<?= $cert['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Revoke Certificate">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
