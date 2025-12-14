<?php
require_once __DIR__ . '/init.php';

// Default accounts to create
$defaults = [
    ['name' => 'Administrator', 'email' => 'admin@petshop.local', 'password' => 'admin123', 'role' => 'admin'],
    ['name' => 'Kasir', 'email' => 'kasir@petshop.local', 'password' => 'kasir123', 'role' => 'kasir'],
    ['name' => 'Owner', 'email' => 'owner@petshop.local', 'password' => 'owner123', 'role' => 'owner'],
];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Default Users - Petshop Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
        .card-header { background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-users me-2"></i> Create Default Users</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        $created_count = 0;
                        $exists_count = 0;

                        foreach ($defaults as $u) {
                            $name = $u['name'];
                            $email = $u['email'];
                            $password = $u['password'];
                            $role = $u['role'];

                            $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
                            $stmt->execute([$email]);
                            if ($stmt->fetch()) {
                                echo "<div class='alert alert-info' role='alert'>";
                                echo "<i class='fas fa-info-circle me-2'></i> User <strong>$email</strong> (Role: <strong>$role</strong>) already exists.";
                                echo "</div>";
                                $exists_count++;
                                continue;
                            }

                            $hash = password_hash($password, PASSWORD_DEFAULT);
                            $ins = $pdo->prepare('INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)');
                            if ($ins->execute([$name, $email, $hash, $role])) {
                                echo "<div class='alert alert-success' role='alert'>";
                                echo "<i class='fas fa-check-circle me-2'></i> ✓ Created <strong>$role</strong> account<br>";
                                echo "<small class='text-muted'>Email: <code>$email</code> | Password: <code>$password</code></small>";
                                echo "</div>";
                                $created_count++;
                            }
                        }
                        ?>

                        <hr>
                        <div class="alert alert-primary" role="alert">
                            <strong><i class="fas fa-check me-2"></i> Summary:</strong><br>
                            Created: <strong><?php echo $created_count; ?></strong> | Already exists: <strong><?php echo $exists_count; ?></strong>
                        </div>

                        <h6 class="mt-4 mb-3"><i class="fas fa-lock me-2"></i> Account Credentials:</h6>
                        <table class="table table-sm table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge bg-danger">admin</span></td>
                                    <td><code>admin@petshop.local</code></td>
                                    <td><code>admin123</code></td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-info">kasir</span></td>
                                    <td><code>kasir@petshop.local</code></td>
                                    <td><code>kasir123</code></td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-warning">owner</span></td>
                                    <td><code>owner@petshop.local</code></td>
                                    <td><code>owner123</code></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="alert alert-warning mt-4" role="alert">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i> Security Notice:</strong><br>
                            <small>This file should be <strong>deleted or restricted</strong> after creating accounts. It should not be accessible on production servers.</small>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="<?php echo BASE_URL; ?>/auth/login.php" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-sign-in-alt me-2"></i> Go to Login
                            </a>
                            <a href="<?php echo BASE_URL; ?>/index.php" class="btn btn-secondary flex-grow-1">
                                <i class="fas fa-home me-2"></i> Go to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
