<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header('Location: ' . ($user['role'] === 'admin' ? 'admin.php' : 'dashboard.php'));
    } else {
        echo "Неправильный логин или пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index-style.css">
    <title>Портал сознательных граждан</title>
</head>
<body>
    <div class="auth-container">
        <h2>Добро пожаловать</h2>
        <p>Авторизуйтесь или зарегистрируйтесь для подачи заявлений.</p>

        <!-- Кнопка для перехода на страницу регистрации -->
        

        <!-- Форма авторизации -->
        <form method="POST">
            <div>
                <label for="login">Логин</label>
                <input type="text" id="login" name="login" required>
            </div>
            <div>
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Войти</button>
        </form>

        <button class="register-btn">
            <a class="reg-btn" href="register.php" class="button">Зарегистрироваться</a>
        </button>
        

    </div>
</body>
</html>
