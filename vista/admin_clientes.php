<?php
session_start();

include '../templates/header.php';
include '../php/admin.php';

if (isset($_SESSION['alert_message'])) {
    echo "<script>alert('" . $_SESSION['alert_message'] . "');</script>";
    unset($_SESSION['alert_message']);
}

if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] != "admin") {
    $_SESSION['alert_message'] = '¡No tienes permisos!';
    header('Location: ../index.php');
    exit();
}

$clientes = obtenerUsuarios();

?>
<main>
    <h2>Administración - Clientes</h2>
    <div class="admin">
    <?php if (empty($clientes)): ?>
            <p>No hay clientes</p>
        <?php else: ?>
            <table class="clientesTabla">
                <thead>
                    <tr>
                        <th>Id_usuario</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Tipo_usuario</th>
                        <th><button><a href="./formAdd_clientes.php">➕🙍‍♂️</a></button></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo $cliente['id_usuario']; ?></td>
                            <td><?php echo $cliente['nombre']; ?></td>
                            <td><?php echo $cliente['email']; ?></td>
                            <td><?php echo $cliente['tipo_usuario']; ?></td>
                            <td>
                                <button><a href="./formModify_clientes.php?id_usuario=<?php echo $cliente['id_usuario']; ?>">📝</a></button>
                                <form action="../php/admin.php" method="post">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id_usuario" value="<?php echo $cliente['id_usuario']; ?>">
                                    <button type="submit">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    <?php endif; ?>
    </div>
</main>
<?php include '../templates/footer.php'; ?>