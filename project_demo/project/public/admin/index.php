<?php
require '../db.php';
session_start();

// Проверка на авторизацию администратора
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

// Обработка формы добавления нового сорта яблок
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_variety'])) {
    $new_variety = trim($_POST['new_variety']);
    if (!empty($new_variety)) {
        $stmt = $pdo->prepare("INSERT INTO apple_varieties (name) VALUES (?)");
        try {
            $stmt->execute([$new_variety]);
            echo "Новый сорт \"$new_variety\" успешно добавлен!";
        } catch (Exception $e) {
            echo "Ошибка: сорт \"$new_variety\" уже существует.";
        }
    } else {
        echo "Название сорта не может быть пустым.";
    }
}

if (isset($_POST['order_id'], $_POST['status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$status, $order_id]);
}

// Получение всех заказов
$stmt = $pdo->query("SELECT o.id, u.full_name, a.name, o.quantity, o.status 
                     FROM orders o 
                     JOIN users u ON o.user_id = u.id 
                     JOIN apple_varieties a ON o.apple_variety_id = a.id");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Получение всех сортов яблок
$stmt = $pdo->query("SELECT * FROM apple_varieties");
$apple_varieties = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Управление заказами</h2>
<ul>
    <?php foreach ($orders as $order): ?>
        <li>
            <?= htmlspecialchars($order['full_name']) ?> заказал <?= $order['quantity'] ?> яблок сорта <?= htmlspecialchars($order['name']) ?>. 
            Статус: <?= $order['status'] ?>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                <select name="status">
                    <option value="new" <?= $order['status'] == 'new' ? 'selected' : '' ?>>Новое</option>
                    <option value="confirmed" <?= $order['status'] == 'confirmed' ? 'selected' : '' ?>>Подтверждено</option>
                    <option value="rejected" <?= $order['status'] == 'rejected' ? 'selected' : '' ?>>Отклонено</option>
                </select>
                <button type="submit">Обновить</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>

<h2>Добавить новый сорт яблок</h2>
<form method="POST">
    <label for="new_variety">Название нового сорта:</label>
    <input type="text" name="new_variety" id="new_variety" required>
    <button type="submit">Добавить</button>
</form>

<h2>Список сортов яблок</h2>
<ul>
    <?php foreach ($apple_varieties as $variety): ?>
        <li><?= htmlspecialchars($variety['name']) ?></li>
    <?php endforeach; ?>
</ul>

<form method="post" action="../index.php">
    <button type="submit">Выйти</button>
</form>