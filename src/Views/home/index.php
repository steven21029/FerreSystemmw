<link rel="stylesheet" href="/FerreSystem/public/css/home.css">

<div class="home-container">

    <!-- LOGO PRINCIPAL -->
    <div class="home-logo-box">
        <img src="/FerreSystem/public/img/logoferreteria.png" id="home-logo" alt="Logo del Sistema">
    </div>

    <!-- TÍTULO E INTRO -->
    <div class="home-header">
        <h1>Bienvenido a FerreSystem</h1>
        <p class="intro">
            Plataforma profesional para la gestión completa de una ferretería:
            productos, inventarios, ventas, compras y administración de usuarios.
        </p>
    </div>

    <!-- TARJETAS DEL EQUIPO -->
    <div class="integrantes-grid">
        <?php foreach ($cards as $c): ?>
            <div class="integrante-card">
                <img src="/FerreSystem/public/img/<?= $c['img'] ?>" class="integrante-img" alt="">
                <h4><?= $c['nombre'] ?></h4>
                <p>Desarrolladores</p>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- MISIÓN -->
    <div class="home-section">
        <h2>Misión</h2>
        <p>
            Proveer una herramienta rápida, moderna y confiable que permita gestionar todos los
            procesos internos de una ferretería de manera eficiente y organizada.
        </p>
    </div>

    <!-- VISIÓN -->
    <div class="home-section">
        <h2>Visión</h2>
        <p>
            Convertirse en el sistema de gestión ferretera líder en la región, apoyando el crecimiento 
            empresarial con tecnología y facilidad de uso.
        </p>
    </div>

    <!-- SERVICIOS -->
    <div class="home-gallery">

        <div class="gallery-card">
            <img src="https://www.datadec.es/hubfs/automatiza-inventario-control-existencias-tiempo-real.png"
                 class="gallery-img" alt="">
            <h3>Control de Inventario</h3>
            <p>
                Administración de productos, existencias, códigos y movimientos de inventario.
            </p>
        </div>

        <div class="gallery-card">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS2yoMs5Cn7O7wrxqHD6d-xXCp_lc7FMdpBNw&s"
                 class="gallery-img" alt="">
            <h3>Gestión de Productos</h3>
            <p>
                Registro, edición y clasificación de herramientas, materiales y artículos de ferretería.
            </p>
        </div>

        <div class="gallery-card">
            <img src="https://quickbooks.intuit.com/oidam/intuit/sbseg/es_mx/blog/image/other/sbseg-rsz_1blake-wisz-q3o_8mtefm0-unsplash.jpg"
                 class="gallery-img" alt="">
            <h3>Ventas y Facturación</h3>
            <p>
                Procesamiento de ventas, generación de facturas y control del flujo de caja.
            </p>
        </div>

    </div>

</div>
