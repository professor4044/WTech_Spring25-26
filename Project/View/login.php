<?php
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'seeker') {
        header('Location: ../Controller/JobController.php?action=index');
    } elseif ($_SESSION['role'] === 'employer') {
        header('Location: ../Controller/EmployerController.php');
    } elseif ($_SESSION['role'] === 'admin') {
        header('Location: ../Controller/AdminController.php');
    }
    exit;
}

require_once '../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = 'Email এবং Password দিন।';
    } else {
        $stmt = $conn->prepare("SELECT id, name, password_hash, role FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user   = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['role']    = $user['role'];

            if ($user['role'] === 'seeker') {
                header('Location: ../Controller/JobController.php?action=index');
            } elseif ($user['role'] === 'employer') {
                header('Location: ../Controller/EmployerController.php');
            } elseif ($user['role'] === 'admin') {
                header('Location: ../Controller/AdminController.php');
            }
            exit;
        } else {
            $error = 'Email বা Password ভুল।';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Job Portal</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 420px;
        }
        .login-box h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 28px;
            font-size: 24px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #333;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: #2c3e50;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 8px;
        }
        .btn-login:hover { background: #1a252f; }
        .error {
            background: #fdecea;
            color: #c0392b;
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 18px;
            font-size: 14px;
        }
        .register-link {
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
            color: #555;
        }
        .register-link a {
            color: #2c3e50;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Job Portal Login</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="your@email.com" 
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn-login">Login</button>
    </form>

    <div class="register-link">
        Account নেই? <a href="register.php">Register করুন</a>
    </div>
</div>
</body>
</html>