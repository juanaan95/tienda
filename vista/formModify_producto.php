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

$id_producto = $_GET['id_producto'];

$producto = obtenerProducto($id_producto);

?>
<main>
    <h2>Administración - Modificar Producto</h2>
    <div class="admin">
        <form action="../php/admin.php" method="post">
            <input type="hidden" name="action" value="modificarProducto">
            <input type="hidden" name="id_producto" value="<?php echo $id_producto?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" placeholder="<?php echo $producto['nombre']; ?>">

            <label for="descripcion">Descripcion:</label>
            <input type="text" id="descripcion" name="descripcion" placeholder="<?php echo $producto['descripcion']; ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="<?php echo $producto['precio']; ?>">

            <label for="stock">Stock:</label>
            <input type ="number" id="stock" name="stock" placeholder="<?php echo $producto['stock']; ?>">
        
            <button type="submit">Modificar Producto</button>
        </form>
    </div>
</main>
<?php include '../templates/footer.php'; ?>