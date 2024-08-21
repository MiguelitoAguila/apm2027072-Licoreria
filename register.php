<?php
include 'db.php';
include 'auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (register($email, $password, $role)) {
        header('Location: login.php');
        exit();
    } else {
        echo 'Error registering user.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <form method="post">
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <label>Role:
            <select name="role">
                <option value="client">Client</option>
                <option value="admin">Admin</option>
            </select>
        </label><br>
        <button type="submit">Register</button>
    </form>
    <p><a href="index.php">Volver al inicio</a></p>
</body>
</html>
