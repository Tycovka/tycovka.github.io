<?php
require '../db.php';
session_start();

$error = '';

// Логика входа администратора
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_login = $_POST['admin_username'];
    $admin_password = $_POST['admin_password'];

    // Проверка в базе данных: ищем администратора по логину
    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ? AND role = 'admin'");
    $stmt->execute([$admin_login]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Если пароль совпадает
    if ($admin && password_verify($admin_password, $admin['password'])) {
        $_SESSION['user'] = $admin;
        header("Location: /admin/index.php");
        exit;
    } else {
        $error = "Неверный логин или пароль для администратора.";
    }
}
?>

<h2>Вход для администратора</h2>

<?php if ($error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="admin_username" placeholder="Логин администратора" required>
    <input type="password" name="admin_password" placeholder="Пароль администратора" required>
    <button type="submit">Войти как администратор</button>
</form>

<p>Не администратор? <a href="../index.php">Войти как пользователь</a></p>
