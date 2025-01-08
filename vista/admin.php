<?php
session_start();

include '../templates/header.php';
include '../php/carrito.php';

$idUsuario = $_SESSION['usuario_id'];

if (isset($_SESSION['alert_message'])) {
    echo "<script>alert('" . $_SESSION['alert_message'] . "');</script>";
    unset($_SESSION['alert_message']);
}

if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] != "admin") {
    $_SESSION['alert_message'] = '¡No tienes permisos!';
    header('Location: index.php');
    exit();
}

?>
<main>
    <h2>Administración</h2>
    <div class="admin">
        <nav>
            <ul>
                <li><a href="./admin_clientes.php">🙍‍♂️ Clientes</a></li>
                <li><a href="./admin_productos.php">👟 Productos</a></li>
            </ul>
        </nav>
    </div>
</main>
<?php include '../templates/footer.php'; ?>