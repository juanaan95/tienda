<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZapatoShop</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header class="header">
        <h1>ZapatoShop</h1>
        <nav>
            <ul>
                <li><a href="../vista/index.php">Inicio</a></li>
                <li><a href="../vista/Productos.php">Productos</a></li>
                <li><a href="../vista/carrito.php">Carrito</a></li>
                <?php if(isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin') { ?>
                    <li><a href="../vista/admin.php">Panel-Admin</a></li>
                <?php } ?>
            </ul>
        </nav>
        <nav>
            <ul>
                <?php if(isset($_SESSION['usuario_id']) && $_SESSION['usuario_id']) { ?>
                    <li><a href="../php/logout.php">Cerrar Sesión</a></li>
                <?php } else { ?>
                    <li><a href="../vista/login.php">Iniciar Sesión</a></li>
                    <li><a href="../vista/registro.php">Registro</a></li>
                <?php } ?>
            </ul>
        </nav>
    </header>



