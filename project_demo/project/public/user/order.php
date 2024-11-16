<?php
require '../db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /login.php");
    exit;
}

// Получение списка сортов яблок из базы данных
$stmt = $pdo->query("SELECT id, name FROM apple_varieties");
$apple_varieties = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $apple_variety_id = $_POST['apple_variety_id'];
    $quantity = intval($_POST['quantity']);
    $user_id = $_SESSION['user']['id'];

    if ($quantity > 0 && $apple_variety_id) {
        // Вставка нового заказа в базу данных
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, apple_variety_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $apple_variety_id, $quantity]);
        echo "Заказ успешно оформлен!";
    } else {
        echo "Пожалуйста, выберите сорт и укажите корректное количество.";
    }
}
?>

<h2>Оформить заказ</h2>
<form method="POST">
    <label for="apple_variety_id">Сорт яблок:</label>
    <select name="apple_variety_id" id="apple_variety_id" required>
        <option value="">-- Выберите сорт --</option>
        <?php foreach ($apple_varieties as $variety): ?>
            <option value="<?= $variety['id'] ?>"><?= htmlspecialchars($variety['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <br><br>
    <label for="quantity">Количество (шт):</label>
    <input type="number" name="quantity" id="quantity" min="1" required>

    <br><br>
    <button type="submit">Оформить заказ</button>
</form>

<a href="index.php">Вернуться к заказам</a>
<form method="post" action="../logout.php">
    <button type="submit">Выйти</button>
</form>