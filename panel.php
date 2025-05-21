<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$message = '';

// uye sil
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $message = "Üye silindi.";
}

// uye ekle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = $_POST['form_type'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    if ($form_type === 'add') {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        $message = "Üye eklendi.";
    } elseif ($form_type === 'edit' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $stmt->execute([$username, $email, $id]);
        $message = "Üye güncellendi.";
    }
}

// uye getir
//uye eklerken validasyon ekledim. mail formatini duzgn gir vs. bunlari kaldirabilirsin
$users = $pdo->query("SELECT * FROM users")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head><title>Admin Panel</title></head>
<body>
<div style="text-align: right;">
    Hoş geldin, <?= htmlspecialchars($_SESSION['admin']) ?> |
    <a href="logout.php">Çıkış Yap</a>
</div>

<h2>Üye Yönetimi</h2>

<p><?= $message ?></p>

<h3>Yeni Üye Ekle</h3>
<form method="POST">
    <input type="hidden" name="form_type" value="add">
    Kullanıcı Adı: <input type="text" name="username" required>
    Email: <input type="email" name="email" required>
    Şifre: <input type="password" name="password" required>
    <input type="submit" value="Ekle">
</form>

<h3>Üyeler</h3>
<table border="1" cellpadding="5" cellspacing="0">
<tr><th>ID</th><th>Kullanıcı Adı</th><th>Email</th><th>İşlemler</th></tr>
<?php foreach ($users as $user): ?>
<tr>
    <form method="POST">
        <input type="hidden" name="form_type" value="edit">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <td><?= $user['id'] ?></td>
        <td><input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required></td>
        <td><input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required></td>
        <td>
            <input type="submit" value="Güncelle">
            <a href="?action=delete&id=<?= $user['id'] ?>" onclick="return confirm('Silinsin mi?')">Sil</a>
        </td>
    </form>
</tr>
<?php endforeach; ?>
</table>

</body>
</html>
