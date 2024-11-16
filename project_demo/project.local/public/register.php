<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (fullname, phone, email, login, password) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$fullname, $phone, $email, $login, $password])) {
        echo "Регистрация успешна!";
    } else {
        echo "Ошибка регистрации.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register-style.css">
    <title>Регистрация - Портал сознательных граждан</title>
</head>
<body>
    <div class="register-container">
        <h2>Регистрация</h2>
        <p>Пожалуйста, заполните форму для регистрации.</p>

        <!-- Форма регистрации -->
        <form method="POST">
            <div>
                <label for="fullname">ФИО</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>
            <div>
                <label for="email">Электронная почта</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="phone">Телефон</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div>
                <label for="login">Логин</label>
                <input type="text" id="login" name="login" required>
            </div>
            <div>
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Зарегистрироваться</button>
        </form>

        <!-- Ссылка на страницу авторизации -->
        <a href="index.php" class="auth-link">Уже есть аккаунт? Войти</a>
    </div>
</body>
</html>

