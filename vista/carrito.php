<?php
session_start();

include '../templates/header.php';
include '../php/carrito.php';

$idUsuario = $_SESSION['usuario_id'];
$carrito = obtenerCarrito($idUsuario);

if (isset($_SESSION['alert_message'])) {
    echo "<script>alert('" . $_SESSION['alert_message'] . "');</script>";
    unset($_SESSION['alert_message']);
}

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['alert_message'] = 'Debes iniciar sesión para ver tu carrito.';
    header('Location: login.php');
    exit();
}

?>
<main>
    <h2>Tu Carrito</h2>
    <div class="carrito">
        <?php if (empty($carrito)): ?>
            <p>Tu carrito está vacío.</p>
        <?php else: ?>
            <table class="carritoTabla">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carrito as $item): ?>
                        <tr>
                            <td><?php echo $item['nombre']; ?></td>
                            <td><?php echo $item['precio']; ?> €</td>
                            <td><?php echo $item['cantidad']; ?></td>
                            <td><?php echo $item['precio'] * $item['cantidad']; ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <form action="../php/carrito.php" method="post">
                <input type="hidden" name="action" value="borrarCarrito">
                <button type="submit">Vaciar Carrito</button>
            </form>
            <form action="../php/carrito.php" method="post">
                <input type="hidden" name="action" value="comprar">
                <button type="submit">Comprar</button>
            </form>
        <?php endif; ?>
    </div>
</main>
<?php include '../templates/footer.php'; ?>