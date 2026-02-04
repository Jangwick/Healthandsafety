<div class="table-container">
    <div class="table-header">
        <div class="table-actions">
            <a href="/inspections/create" class="btn btn-primary">
                <i class="fas fa-calendar-plus"></i> Schedule Inspection
            </a>
        </div>
    </div>
    
    <table class="datatable">
        <thead>
            <tr>
                <th>Establishment</th>
                <th>Inspector</th>
                <th>Date</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Score</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inspections as $insp): ?>
            <tr>
                <td><?= htmlspecialchars($insp['business_name']) ?></td>
                <td><?= htmlspecialchars($insp['inspector_name']) ?></td>
                <td><?= $insp['scheduled_date'] ?></td>
                <td>
                    <span class="priority-badge priority-<?= strtolower($insp['priority']) ?>">
                        <?= $insp['priority'] ?>
                    </span>
                </td>
                <td>
                    <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $insp['status'])) ?>">
                        <?= $insp['status'] ?>
                    </span>
                </td>
                <td><?= $insp['score'] ? number_format($insp['score'], 1) . '%' : '-' ?></td>
                <td>
                    <?php if ($insp['status'] === 'Scheduled' || $insp['status'] === 'In Progress'): ?>
                        <a href="/inspections/conduct?id=<?= $insp['id'] ?>" class="btn btn-sm btn-success">Conduct</a>
                    <?php else: ?>
                        <a href="/inspections/report?id=<?= $insp['id'] ?>" class="btn btn-sm btn-info">Report</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
