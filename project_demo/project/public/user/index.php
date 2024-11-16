<?php
require '../db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("SELECT o.id, a.name, o.quantity, o.status FROM orders o JOIN apple_varieties a ON o.apple_variety_id = a.id WHERE o.user_id = ?");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Ваши заказы</h2>
<ul>
    <?php foreach ($orders as $order): ?>
        <li>
            Сорт: <?= htmlspecialchars($order['name']) ?>, Количество: <?= $order['quantity'] ?>, Статус: <?= $order['status'] ?>
        </li>
    <?php endforeach; ?>
</ul>

<a href="order.php">Создать заказ</a>

<form method="post" action="../index.php">
    <button type="submit">Выйти</button>
</form>