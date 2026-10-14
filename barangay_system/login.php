<?php
require_once "session.php";
require_once "pdo.php";

$error = "";
if (isset($_POST['login'])) {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['name']    = $user['name'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Barangay System — Login</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="login-box">
    <h2>🏘️ Barangay Records</h2>
    <p style="text-align:center;color:#666;">Please log in to continue</p>

    <?php if ($error): ?>
        <p class="message error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <p>Email:<br><input type="email" name="email" required autofocus></p>
        <p>Password:<br><input type="password" name="password" required></p>
        <input type="submit" name="login" value="Login" class="add-button" style="width:100%;">
    </form>

    <p style="text-align:center;font-size:13px;color:#999;margin-top:18px;">
        Demo: admin@barangay.com / admin123
    </p>
</div>
</body>
</html>