<?php
include_once './conection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'registrar') {

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($nombre) || empty($email) || empty($password)) {
        die('Por favor, completa todos los campos.');
    }

    $conn = conectarBD();

    $stmt = $conn->prepare('SELECT id_usuario FROM clientes WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        session_start();
        $_SESSION['alert_message'] = 'El correo ya está registrado. Intenta con otro.';
        header('Location: ../vista/registro.php');
        exit();
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        
        $stmt = $conn->prepare('INSERT INTO clientes (nombre, email, password, tipo_usuario) VALUES (:nombre, :email, :password, "user")');
    
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);
    
        if ($stmt->execute()) {
            session_start();
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_tipo'] = "user";

            header('Location: ../vista/index.php');
        } else {
            echo 'Error al registrar el usuario.';
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        die('Por favor, completa todos los campos.');
    }

    try {
        $conn = conectarBD();

        $stmt = $conn->prepare('SELECT email, password, nombre, tipo_usuario, id_usuario FROM clientes WHERE email = :email');
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            if (password_verify($password, $usuario['password'])) {
                session_start();
                $_SESSION['alert_message'] = 'Login exitoso. Bienvenido, ' . $usuario['nombre'] . '!';
                $_SESSION['usuario_id'] = $usuario['id_usuario'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_tipo'] = $usuario['tipo_usuario'];

                header('Location: ../vista/index.php');
                exit();
            } else {
                session_start();
                $_SESSION['alert_message'] = 'Email o constraseña incorrecta.';
                header('Location: ../vista/login.php');
            }
        } else {
            session_start();
            $_SESSION['alert_message'] = 'Email o constraseña incorrecta.';
            header('Location: ../vista/login.php');
        }
    } catch (PDOException $e) {
        echo 'Error en la base de datos: ' . $e->getMessage();
    }
    
}
?>