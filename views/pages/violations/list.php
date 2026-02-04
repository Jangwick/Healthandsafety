<div class="card">
    <div class="card-header">
        <h3 class="card-title">Recorded Violations</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Establishment</th>
                        <th>Description</th>
                        <th>Fine Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($violations ?? [] as $violation): ?>
                        <tr>
                            <td>#<?= $violation['id'] ?></td>
                            <td><?= htmlspecialchars($violation['establishment_name']) ?></td>
                            <td><?= htmlspecialchars(substr($violation['description'], 0, 50)) ?>...</td>
                            <td>₱<?= number_format((float)$violation['fine_amount'], 2) ?></td>
                            <td>
                                <span class="badge badge-<?= $violation['status'] === 'Paid' ? 'success' : 'danger' ?>">
                                    <?= $violation['status'] ?>
                                </span>
                            </td>
                            <td><?= date('M d, Y', strtotime($violation['created_at'])) ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="/violations/show?id=<?= $violation['id'] ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
