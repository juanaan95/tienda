<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'conection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'addProduct') {

    session_start();
    $idProducto = $_POST['idProducto'];
    $cantidad = $_POST['cantidad'];
    $idUsuario = $_SESSION['usuario_id'];

    $conn = conectarBD();

    try {
        $stmt = $conn->prepare("SELECT id_carrito FROM carrito WHERE id_usuario = :idUsuario");
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();
        $carrito = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($carrito) {
            $idCarrito = $carrito['id_carrito'];
        } else {
            $fecha = date('Y-m-d H:i:s');
            $stmt = $conn->prepare("INSERT INTO carrito (id_usuario, fecha) VALUES (:idUsuario, :fecha)");
            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->execute();
            $idCarrito = $conn->lastInsertId();
        }

        $stmt = $conn->prepare("SELECT cantidad FROM carrito_productos WHERE id_carrito = :idCarrito AND id_producto = :idProducto");
        $stmt->bindParam(':idCarrito', $idCarrito);
        $stmt->bindParam(':idProducto', $idProducto);
        $stmt->execute();
        $productoExistente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($productoExistente) {
            $nuevaCantidad = $productoExistente['cantidad'] + $cantidad;
            $stmt = $conn->prepare("UPDATE carrito_productos SET cantidad = :cantidad WHERE id_carrito = :idCarrito AND id_producto = :idProducto");
            $stmt->bindParam(':cantidad', $nuevaCantidad);
            $stmt->bindParam(':idCarrito', $idCarrito);
            $stmt->bindParam(':idProducto', $idProducto);
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("INSERT INTO carrito_productos (id_carrito, id_producto, cantidad) VALUES (:idCarrito, :idProducto, :cantidad)");
            $stmt->bindParam(':idCarrito', $idCarrito);
            $stmt->bindParam(':idProducto', $idProducto);
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->execute();
        }
        $_SESSION['alert_message'] = 'Producto agregado al carrito.';
        header('Location: ../vista/carrito.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['alert_message'] = "Error: " . $e->getMessage();
        header('Location: ../vista/carrito.php');
        exit();
    }
}

function obtenerCarrito($idUsuario) { 
    $conn = conectarBD();

    try {
        $stmt = $conn->prepare("SELECT c.id_carrito, p.nombre, p.precio, cp.cantidad FROM carrito c JOIN carrito_productos cp ON c.id_carrito = cp.id_carrito JOIN productos p ON cp.id_producto = p.id_producto WHERE c.id_usuario = :idUsuario");
        $stmt->execute([':idUsuario' => $idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'borrarCarrito') {
    session_start();
    $carrito = obtenerCarrito($_SESSION['usuario_id']);
    $idCarrito = $carrito[0]['id_carrito'];
    
    $conn = conectarBD();

    try {
        $stmt = $conn->prepare("DELETE FROM carrito_productos WHERE id_carrito = :idCarrito");
        $stmt->execute([':idCarrito' => $idCarrito]);
        $_SESSION['alert_message'] = 'Carrito eliminado.';
        header('Location: ../vista/carrito.php');
        exit();
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'comprar') {
    session_start();
    $carrito = obtenerCarrito($_SESSION['usuario_id']);
    $idCarrito = $carrito[0]['id_carrito'];
    
    $conn = conectarBD();

    try {
        $stmt = $conn->prepare("DELETE FROM carrito_productos WHERE id_carrito = :idCarrito");
        $stmt->execute([':idCarrito' => $idCarrito]);
        $_SESSION['alert_message'] = 'Compra realizada.';
        header('Location: ../vista/carrito.php');
        exit();
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

?>