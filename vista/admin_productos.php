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

$productos = obtenerProductos();

?>
<main>
    <h2>Administración - Productos</h2>
    <div class="admin">
    <?php if (empty($productos)): ?>
            <p>No hay productos</p>
        <?php else: ?>
            <table class="clientesTabla">
                <thead>
                    <tr>
                        <th>Id_Producto</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th><button><a href="./formAdd_producto.php">➕👟</a></button></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo $producto['id_producto']; ?></td>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td><?php echo $producto['descripcion']; ?></td>
                            <td><?php echo $producto['precio']; ?></td>
                            <td><?php echo $producto['stock']; ?></td>
                            <td>
                                <button><a href="./formModify_producto.php?id_producto=<?php echo $producto['id_producto']; ?>">📝</a></button>
                                <form action="../php/admin.php" method="post">
                                    <input type="hidden" name="action" value="deleteProduct">
                                    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                                    <button type="submit">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    <?php endif; ?>
    </div>
</main>
<?php include '../templates/footer.php'; ?>