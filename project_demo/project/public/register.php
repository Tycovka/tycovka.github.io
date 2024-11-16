<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (full_name, phone, email, login, password) VALUES (?, ?, ?, ?, ?)");
    try {
        $stmt->execute([$full_name, $phone, $email, $login, $password]);
        echo "Регистрация прошла успешно!";
    } catch (Exception $e) {
        echo "Ошибка регистрации: " . $e->getMessage();
    }
}
?>

<form method="POST">
    <input type="text" name="full_name" placeholder="ФИО" required>
    <input type="text" name="phone" placeholder="Телефон" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="text" name="login" placeholder="Логин" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Зарегистрироваться</button>
</form>

<p>Уже есть аккаунт? <a href="index.php">Войти</a></p>