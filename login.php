<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

   
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $admin = $stmt->fetch();

    if ($admin) {
        $_SESSION['admin'] = $admin['username'];
        header("Location: panel.php");
        exit;
    } else {
        $error = "Kullanıcı adı veya şifre yanlış!";
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Kullanıcı Adı" required><br>
    <input type="password" name="password" placeholder="Şifre" required><br>
    <input type="submit" value="Giriş Yap">
</form>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
