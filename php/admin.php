<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'conection.php';

function obtenerUsuarios() {
    $conn = conectarBD();

    try {
        $stmt = $conn->prepare("SELECT * FROM clientes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
        return "Error: " . $th->getMessage();
    }
}

function obtenerUsuario($id_usuario) {
    $conn = conectarBD();

    try {
        $stmt = $conn->prepare("SELECT * FROM clientes WHERE id_usuario = :idusuario");
        $stmt->execute([':idusuario' => $id_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
        return "Error: " . $th->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
    session_start();
    $idusuario = $_POST['id_usuario'];

    $conn = conectarBD();
    try {
        $stmt = $conn->prepare("DELETE FROM clientes WHERE id_usuario = :idusuario");
        $stmt->execute([':idusuario' => $idusuario]);
        $_SESSION['alert_message'] = "Usuario eliminado.";
        header('Location: ../vista/admin_clientes.php');
        exit();
    } catch (\Throwable $th) {
        return "Error: " . $th->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'crearCliente') {

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    if (empty($nombre) || empty($email) || empty($password) || empty($rol) ) {
        die('Por favor, completa todos los campos.');
    }

    $conn = conectarBD();

    $stmt = $conn->prepare('SELECT id_usuario FROM clientes WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        session_start();
        $_SESSION['alert_message'] = 'El correo ya está registrado. Intenta con otro.';
        header('Location: ../vista/admin_clientes.php');
        exit();
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        
        $stmt = $conn->prepare('INSERT INTO clientes (nombre, email, password, tipo_usuario) VALUES (:nombre, :email, :password, :rol)');
    
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':rol', $rol);
    
        if ($stmt->execute()) {
            header('Location: ../vista/admin_clientes.php');
        } else {
            echo 'Error al registrar el usuario.';
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'modificarCliente') {

    $id_usuario = $_POST['id_usuario'];

    $conn = conectarBD();

    $updateFields = [];
    $params = [];

    if (!empty($_POST['nombre'])) {
        $updateFields[] = 'nombre = :nombre';
        $params[':nombre'] = $_POST['nombre'];
    }

    if (!empty($_POST['email'])) {
        $stmt = $conn->prepare('SELECT id_usuario FROM clientes WHERE email = :email AND id_usuario != :id_usuario');
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            session_start();
            $_SESSION['alert_message'] = 'El correo ya está registrado. Intenta con otro.';
            header('Location: ../vista/admin_clientes.php');
            exit();
        }

        $updateFields[] = 'email = :email';
        $params[':email'] = $_POST['email'];
    }

    if (!empty($_POST['password'])) {
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $updateFields[] = 'password = :password';
        $params[':password'] = $passwordHash;
    }

    if (!empty($_POST['rol'])) {
        $updateFields[] = 'tipo_usuario = :rol';
        $params[':rol'] = $_POST['rol'];
    }

    $updateQuery = 'UPDATE clientes SET ' . implode(', ', $updateFields) . ' WHERE id_usuario = :id_usuario';
    $params[':id_usuario'] = $id_usuario;

    try {
        $stmt = $conn->prepare($updateQuery);

        if ($stmt->execute($params)) {
            session_start();
            $_SESSION['alert_message'] = 'Cliente modificado correctamente.';
            header('Location: ../vista/admin_clientes.php');
        } else {
            echo 'Error al modificar el cliente.';
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

function obtenerProductos() {
    $conn = conectarBD();

    try {
        $stmt = $conn->prepare("SELECT * FROM productos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
        return "Error: " . $th->getMessage();
    }
}

function obtenerProducto($id_producto) {
    $conn = conectarBD();

    try {
        $stmt = $conn->prepare("SELECT * FROM productos WHERE id_producto = :idproducto");
        $stmt->execute([':idproducto' => $id_producto]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
        return "Error: " . $th->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'deleteProduct') {
    session_start();
    $idProducto = $_POST['id_producto'];

    $conn = conectarBD();
    try {
        $stmt = $conn->prepare("DELETE FROM productos WHERE id_producto = :idproducto");
        $stmt->execute([':idproducto' => $idProducto]);
        $_SESSION['alert_message'] = "Producto eliminado.";
        header('Location: ../vista/admin_productos.php');
        exit();
    } catch (\Throwable $th) {
        die("Error: " . $th->getMessage());
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'modificarProducto') {

    $id_producto = $_POST['id_producto'];

    $conn = conectarBD();

    $updateFields = [];
    $params = [];

    if (!empty($_POST['nombre'])) {
        $updateFields[] = 'nombre = :nombre';
        $params[':nombre'] = $_POST['nombre'];
    }

    if (!empty($_POST['descripcion'])) {
        $updateFields[] = 'descripcion = :descripcion';
        $params[':descripcion'] = $_POST['descripcion'];
    }

    if (!empty($_POST['precio'])) {
        $updateFields[] = 'precio = :precio';
        $params[':precio'] = $_POST['precio'];
    }

    if (!empty($_POST['stock'])) {
        $updateFields[] = 'stock = :stock';
        $params[':stock'] = $_POST['stock'];
    }

    $updateQuery = 'UPDATE productos SET ' . implode(', ', $updateFields) . ' WHERE id_producto = :id_producto';
    $params[':id_producto'] = $id_producto;

    try {
        $stmt = $conn->prepare($updateQuery);

        if ($stmt->execute($params)) {
            session_start();
            $_SESSION['alert_message'] = 'Producto modificado correctamente.';
            header('Location: ../vista/admin_productos.php');
        } else {
            echo 'Error al modificar el producto.';
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'crearProducto') {

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    if (empty($nombre) || empty($descripcion) || empty($precio) || empty($stock) ) {
        die('Por favor, completa todos los campos.');
    }

    $conn = conectarBD();

    $stmt = $conn->prepare('SELECT id_producto FROM productos WHERE nombre = :nombre');
    $stmt->bindParam(':nombre', $nombre);
    $stmt->execute();

    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        session_start();
        $_SESSION['alert_message'] = 'El nombre de producto ya existe. Intenta con otro.';
        header('Location: ../vista/admin_productos.php');
        exit();
    }

    try {
        
        $stmt = $conn->prepare('INSERT INTO productos (nombre, descripcion, precio, stock) VALUES (:nombre, :descripcion, :precio, :stock)');
    
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':stock', $stock);
    
        if ($stmt->execute()) {
            header('Location: ../vista/admin_productos.php');
        } else {
            echo 'Error al registrar el producto.';
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }

}

?>