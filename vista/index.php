<?php 
session_start();

include '../templates/header.php';

if (isset($_SESSION['alert_message'])) {
    echo "<script>alert('" . $_SESSION['alert_message'] . "');</script>";
    unset($_SESSION['alert_message']);
}
?>
<main>
    <h2>Bienvenido a nuestra tienda online</h2>
    <p>Explora nuestras zapatillas deportivas y haz tus compras fácilmente.</p>
    <?php 
            echo 'Bienvenido, ' . $_SESSION['usuario_nombre'] ;
    ?>
</main>
<?php include '../templates/footer.php'; ?>
