<?php
session_start();
session_unset();  // Удаляет все переменные сессии
session_destroy();  // Завершает сессию
header('Location: login.php');  // Перенаправляет на страницу входа
exit;
?>
