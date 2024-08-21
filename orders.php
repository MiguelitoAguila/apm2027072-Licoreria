<?php
include 'db.php';
include 'auth.php';

if (!isClient()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $stmt = $pdo->prepare("INSERT INTO orders (product_id, quantity, user_id) VALUES (:product_id, :quantity, :user_id)");
    $stmt->execute(['product_id' => $productId, 'quantity' => $quantity, 'user_id' => $_SESSION['user']['id']]);

    // Obtener el ID de la última orden insertada
    $orderId = $pdo->lastInsertId();
    
    // Redirigir al recibo
    header('Location: receipt.php?order_id=' . $orderId);
    exit();
}

$products = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Realizar Pedido</title>
</head>
<body>
    <h1>Realizar Pedido</h1>
    <form method="post">
        <label>Producto:
            <select name="product_id">
                <?php foreach ($products as $product): ?>
                    <option value="<?php echo htmlspecialchars($product['id']); ?>"><?php echo htmlspecialchars($product['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <label>Cantidad: <input type="number" name="quantity" required></label><br>
        <button type="submit">Realizar Pedido</button>
    </form>

    <p><a href="index.php">Volver al inicio</a></p>
</body>
</html>
