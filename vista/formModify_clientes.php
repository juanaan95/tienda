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

$id_usuario = $_GET['id_usuario'];

$cliente = obtenerUsuario($id_usuario);

?>
<main>
    <h2>Administración - Modificar cliente</h2>
    <div class="admin">
        <form action="../php/admin.php" method="post">
            <input type="hidden" name="action" value="modificarCliente">
            <input type="hidden" name="id_usuario" value="<?php echo $id_usuario?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" placeholder="<?php echo $cliente['nombre']; ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="<?php echo $cliente['email']; ?>">

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password">

            <label for="rol">Rol:</label>
            <select id="rol" name="rol" >
                <option value="user" <?php echo $cliente['tipo_usuario'] === 'user' ? 'selected' : ''; ?>>User</option>
                <option value="admin" <?php echo $cliente['tipo_usuario'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
            <button type="submit">Modificar Cliente</button>
        </form>
    </div>
</main>
<?php include '../templates/footer.php'; ?>