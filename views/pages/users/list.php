<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">System Users</h3>
        <button class="btn btn-primary btn-sm">
            <i class="fas fa-user-plus"></i> Add User
        </button>
    </div>
    <div class="card-body">
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
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
