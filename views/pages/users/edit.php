<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card bg-dark border-secondary">
                <div class="card-header border-secondary d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white">Edit User: <?= htmlspecialchars($user['full_name']) ?></h5>
                    <a href="/users" class="btn btn-secondary btn-sm">Back to List</a>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                    <?php endif; ?>

                    <form action="/users/update" method="POST">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        
                        <div class="mb-3">
                            <label class="form-label text-white-50 small text-uppercase">Full Name</label>
                            <input type="text" name="full_name" class="form-control bg-dark border-secondary text-white" value="<?= htmlspecialchars($user['full_name']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50 small text-uppercase">Email Address</label>
                            <input type="email" name="email" class="form-control bg-dark border-secondary text-white" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50 small text-uppercase">New Password (leave blank to keep current)</label>
                            <input type="password" name="password" class="form-control bg-dark border-secondary text-white">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white-50 small text-uppercase">System Role</label>
                            <select name="role_id" class="form-select bg-dark border-secondary text-white" required>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role['id'] ?>" <?= $user['role_id'] == $role['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($role['name']) ?> (Lvl: <?= $role['hierarchy_level'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Update User Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>