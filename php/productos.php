<?php
// productos.php
include 'conection.php';

function crearProducto($nombre, $descripcion, $precio, $imagen) {
    $conn = conectarBD();

    try {
        $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen) VALUES (:nombre, :descripcion, :precio, :imagen)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':imagen' => $imagen
        ]);
        return true;
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

function obtenerProductos() {
    $conn = conectarBD();

    try {
        $stmt = $conn->prepare("SELECT * FROM productos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

function eliminarProducto($id) {
    $conn = conectarBD();

    try {
        $sql = "DELETE FROM productos WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return true;
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

?>
