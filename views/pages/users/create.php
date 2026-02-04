<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card bg-dark border-secondary">
                <div class="card-header border-secondary d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white">Create New User</h5>
                    <a href="/users" class="btn btn-secondary btn-sm">Back to List</a>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                    <?php endif; ?>

                    <form action="/users/store" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-white-50 small text-uppercase">Full Name</label>
                            <input type="text" name="full_name" class="form-control bg-dark border-secondary text-white" placeholder="e.g. Inspector John Doe" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50 small text-uppercase">Email Address</label>
                            <input type="email" name="email" class="form-control bg-dark border-secondary text-white" placeholder="email@example.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50 small text-uppercase">Temporary Password</label>
                            <input type="password" name="password" class="form-control bg-dark border-secondary text-white" required>
                            <div class="form-text text-muted small">Must be at least 8 characters.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50 small text-uppercase">System Role</label>
                            <select name="role_id" class="form-select bg-dark border-secondary text-white" required>
                                <option value="">Select a role...</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role['id'] ?>"><?= htmlspecialchars($role['name']) ?> (Lvl: <?= $role['hierarchy_level'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Create User Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>