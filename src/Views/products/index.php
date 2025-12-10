<link rel="stylesheet" href="/FerreSystem/public/css/products.css">

<h2 class="titulo-productos">Productos</h2>

<?php
$areas = [
    "Área Eléctrica" => [
        "Cable eléctrico #12",
        "Interruptor sencillo",
        "Tomacorriente doble",
        "Foco LED 12W"
    ],
    "Área Pinturas" => [
        "Pintura negra 1 galón",
        "Pintura blanca 1 galón",
        "Thinner industrial",
        "Rodillo de pintura 9\""
    ],
    "Área Ferretería / Herramientas" => [
        "Martillo de acero 16oz",
        "Llave inglesa 10\"",
        "Alicate universal 8\"",
        "Destornillador Phillips #2"
    ],
    "Área Construcción" => [
        "Cemento gris 42kg",
        "Block sólido 15x20x40",
        "Arena fina 1m³",
        "Varilla 3/8\""
    ]
];

function perteneceArea($producto, $lista) {
    foreach ($lista as $nombre) {
        if (strcasecmp($producto["name"], $nombre) === 0) {
            return true;
        }
    }
    return false;
}

$role = $_SESSION["user"]["role"];
?>

<?php foreach ($areas as $areaNombre => $listaProductos): ?>

    <h3 class="titulo-categoria"><?= $areaNombre ?></h3>

    <div class="productos-grid">

        <?php foreach ($products as $p): ?>
            <?php if (perteneceArea($p, $listaProductos)): ?>

                <div class="producto-card">

                    <!-- IMAGEN SIN CLIC -->
                    <img 
                        src="<?= !empty($p['image_url']) ? $p['image_url'] : '/FerreSystem/public/img/no-image.png' ?>"
                        class="producto-img"
                    >

                    <div class="producto-info">
                        <h3 class="producto-nombre"><?= $p['name'] ?></h3>
                        <p class="producto-precio">L. <?= number_format($p['price'], 2) ?></p>
                        <p class="producto-stock">Stock: <?= intval($p['stock']) ?></p>
                    </div>

                    <div class="acciones-card">

                        <?php if ($role !== "bodega"): ?>

                            <?php if (intval($p["stock"]) > 0): ?>

                                <form action="?controller=cart&action=add" method="POST" class="form-carrito">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <input type="hidden" name="name" value="<?= htmlspecialchars($p['name']) ?>">
                                    <input type="hidden" name="price" value="<?= $p['price'] ?>">

                                    <button type="submit" class="btn-carrito">
                                        Agregar al carrito
                                    </button>
                                </form>

                            <?php else: ?>
                                <button class="btn-sin-stock" disabled>Sin stock</button>
                            <?php endif; ?>

                        <?php endif; ?>

                        <?php if ($role !== "cliente"): ?>

                            <a href="?controller=product&action=edit&id=<?= $p['id'] ?>" class="btn btn-primary">
                                Editar
                            </a>

                            <?php if ($role === "admin"): ?>
                                <a href="?controller=product&action=delete&id=<?= $p['id'] ?>" class="btn btn-danger">
                                    Eliminar
                                </a>
                            <?php endif; ?>

                        <?php endif; ?>

                    </div>

                </div>

            <?php endif; ?>
        <?php endforeach; ?>

    </div>

<?php endforeach; ?>
