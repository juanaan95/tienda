<?php
// connection.php

function conectarBD() {
    $servidor = "localhost"; // Cambia según tu configuración
    $usuario = "root";       // Cambia según tu configuración
    $password = "";          // Cambia según tu configuración
    $baseDatos = "tienda-online"; // Cambia al nombre de tu base de datos

    try {
        // Crear la conexión con PDO
        $dsn = "mysql:host=$servidor;dbname=$baseDatos;charset=utf8mb4";
        $conexion = new PDO($dsn, $usuario, $password);

        // Configurar PDO para que lance excepciones en caso de error
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conexion;
    } catch (PDOException $e) {
        // Manejo de errores
        die("Error en la conexión: " . $e->getMessage());
    }
}
?>