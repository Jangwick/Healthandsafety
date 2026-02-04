<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">System Users</h3>
        <a href="/users/create" class="btn btn-primary btn-sm">
            <i class="fas fa-user-plus"></i> Add User
        </a>
    </div>
    <div class="card-body">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users ?? [] as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                                    </div>
                                    <?= htmlspecialchars($user['full_name']) ?>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <span class="badge badge-outline-primary"><?= $user['role_name'] ?></span>
                            </td>
                            <td>
                                <span class="badge badge-success">Active</span>
                            </td>
                            <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                            <td>
                                <div class="btn-group">
                                    <?php if ($user['role_name'] === 'Inspector'): ?>
                                        <a href="/inspections/create?inspector_id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-success" title="Assign to Audit">
                                            <i class="fas fa-calendar-plus"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="/users/edit?id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/users/delete?id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="fas fa-trash"></i>
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
