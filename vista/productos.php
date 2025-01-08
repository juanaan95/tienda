<?php
session_start();

include '../templates/header.php';
include '../php/productos.php';
$productos = obtenerProductos();
?>
<main>
    <h2>Catálogo de Productos</h2>
    <div class="productos">
        <?php foreach ($productos as $producto): ?>
            <div class="producto">
                <h3><?php echo $producto['nombre']; ?></h3>
                <p><?php echo $producto['descripcion']; ?></p>
                <p>Precio: <?php echo $producto['precio']; ?> €</p>
                <form action="../php/carrito.php" method="post">
                    <input type="hidden" name="idProducto" value="<?php echo $producto['id_producto']; ?>">                    
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" name="cantidad" min="1" max="10" required>
                    
                    <button type="submit" name="action" value="addProduct">Agregar al Carrito</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php include '../templates/footer.php'; ?>