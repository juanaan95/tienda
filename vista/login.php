<?php 
session_start();

if (isset($_SESSION['alert_message'])) {
    echo "<script>alert('" . $_SESSION['alert_message'] . "');</script>";
    unset($_SESSION['alert_message']);
}
include '../templates/header.php'; 
?>
<main>
    <h2>Iniciar Sesión</h2>
    <form action="../php/usuarios.php" method="post">
        <input type="hidden" name="action" value="login">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Iniciar Sesión</button>
    </form>
</main>
<?php include '../templates/footer.php'; ?>