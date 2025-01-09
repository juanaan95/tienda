<?php 
session_start();

include '../templates/header.php';

if (isset($_SESSION['alert_message'])) {
    echo "<script>alert('" . $_SESSION['alert_message'] . "');</script>";
    unset($_SESSION['alert_message']);
}
?>
<?php 
        if (isset($_SESSION['usuario_nombre'])) {
            echo 'Bienvenido, ' . htmlspecialchars($_SESSION['usuario_nombre']);
        } else {
            echo 'Bienvenido, invitado. Inicia sesión para una experiencia personalizada.';
        }
?>
<?php include '../templates/footer.php'; ?>
