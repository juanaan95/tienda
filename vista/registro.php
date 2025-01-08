<?php include '../templates/header.php'; 
session_start();

if (isset($_SESSION['alert_message'])) {
    echo "<script>alert('" . $_SESSION['alert_message'] . "');</script>";
    unset($_SESSION['alert_message']);
}
?>
<main>
    <h2>Registro de Usuario</h2>
    <form action="../php/usuarios.php" method="post">
        <input type="hidden" name="action" value="registrar">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Registrar</button>
    </form>
</main>
<?php include '../templates/footer.php'; ?>