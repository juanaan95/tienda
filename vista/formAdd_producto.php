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
    <h2>Administración - Crear Producto</h2>
    <div class="admin">
        <form action="../php/admin.php" method="post">
            <input type="hidden" name="action" value="crearProducto">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="Descripcion">Descripcion:</label>
            <input type="text" id="descripcion" name="descripcion" required>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" required>

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" required>

            </select>
            <button type="submit">Crear Producto</button>
        </form>
    </div>
</main>
<?php include '../templates/footer.php'; ?>