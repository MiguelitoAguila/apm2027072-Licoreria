<?php
include 'db.php';
include 'auth.php';

if (!isClient()) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['order_id'])) {
    echo 'Order ID is missing.';
    exit();
}

$orderId = $_GET['order_id'];

// Obtener detalles de la orden
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :id");
$stmt->execute(['id' => $orderId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo 'Order not found.';
    exit();
}

// Obtener detalles del producto
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute(['id' => $order['product_id']]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo 'Product not found.';
    exit();
}

// Calcular el total
$total = $product['price'] * $order['quantity'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .receipt {
            border: 1px solid #000;
            padding: 10px;
            max-width: 400px;
            margin: auto;
        }
        .receipt h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <h2>Recibo de Compra</h2>
        <p><strong>Orden ID:</strong> <?php echo htmlspecialchars($order['id']); ?></p>
        <p><strong>Producto:</strong> <?php echo htmlspecialchars($product['name']); ?></p>
        <p><strong>Cantidad:</strong> <?php echo htmlspecialchars($order['quantity']); ?></p>
        <p><strong>Precio Unitario:</strong> $<?php echo number_format($product['price'], 2); ?></p>
        <p><strong>Total:</strong> $<?php echo number_format($total, 2); ?></p>
        
        <!-- Si necesitas mostrar el cambio, puedes agregar un campo de pago y calcular el cambio -->
        <!-- Ejemplo -->
        <form method="post">
            <label for="amount_paid">Monto Pagado:</label>
            <input type="number" id="amount_paid" name="amount_paid" step="0.01" required>
            <button type="submit">Calcular Cambio</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['amount_paid'])) {
            $amountPaid = $_POST['amount_paid'];
            $change = $amountPaid - $total;
            if ($change >= 0) {
                echo '<p><strong>Cambio:</strong> $' . number_format($change, 2) . '</p>';
            } else {
                echo '<p><strong>El monto pagado no es suficiente.</strong></p>';
            }
        }
        ?>
    </div>
    <p><a href="index.php">Volver al inicio</a></p>
</body>
</html>
