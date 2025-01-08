<?php
session_start();

include '../templates/header.php';
include '../php/admin.php';

if (isset($_SESSION['alert_message'])) {
    echo "<script>alert('" . $_SESSION['alert_message'] . "');</script>";
    unset($_SESSION['alert_message']);
}

if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] != "admin") {
    $_SESSION['alert_message'] = '¡No tienes permisos!';
    header('Location: ../index.php');
    exit();
}

?>
<main>
    <h2>Administración - Crear Cliente</h2>
    <div class="admin">
        <form action="../php/admin.php" method="post">
            <input type="hidden" name="action" value="crearCliente">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Crear Cliente</button>
        </form>
    </div>
</main>
<?php include '../templates/footer.php'; ?>