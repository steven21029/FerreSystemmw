<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? "FerreSystem" ?></title>
    <link rel="stylesheet" href="/FerreSystem/public/css/styles.css">
</head>

<body>

<header class="header">
    <h1 class="logo">FerreSystem</h1>

    <nav class="menu">
        <a href="?controller=home&action=index">Inicio</a>

        <?php if (!empty($_SESSION["user"])): ?>
            <?php $role = $_SESSION["user"]["role"]; ?>

            <?php if ($role === "admin"): ?>
                <a href="?controller=user&action=index">Usuarios</a>
                <a href="?controller=role&action=index">Roles</a>
                <a href="?controller=function&action=index">Funciones</a>
                <a href="?controller=userRole&action=index">Usuarios-Roles</a>
                <a href="?controller=roleFunction&action=index">Roles-Funciones</a>
                <a href="?controller=product&action=index">Productos</a>
                <a href="?controller=inventory&action=index">Inventario</a>
                <a href="?controller=report&action=index">Reportes</a>
                <a href="?controller=sale&action=index">Ventas</a>
                <a href="?controller=cart&action=index">Carrito</a>
            <?php endif; ?>

            <?php if ($role === "cliente"): ?>
                <a href="?controller=product&action=index">Productos</a>
                <a href="?controller=cart&action=index">Carrito</a>
                <a href="?controller=sale&action=index">Mis Compras</a>
            <?php endif; ?>

            <?php if ($role === "bodega"): ?>
                <a href="?controller=product&action=index">Productos</a>
                <a href="?controller=inventory&action=index">Inventario</a>
                <a href="?controller=sale&action=index">Ventas</a>
            <?php endif; ?>

            <a href="?controller=auth&action=logout">Cerrar sesión</a>
        <?php endif; ?>
    </nav>
</header>

<main class="content">
    <?= $content ?>
</main>

<footer class="footer">
    <p>FerreSystem © <?= date("Y") ?></p>
</footer>

</body>
</html>

