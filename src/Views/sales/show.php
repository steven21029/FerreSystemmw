<h4>Detalle de Venta #<?= $sale["id"] ?></h4>

<a href="index.php?controller=sale&action=index" class="btn grey">← Volver</a>
<br><br>

<!-- INFORMACIÓN PRINCIPAL DE LA VENTA -->
<div class="card-panel light-blue lighten-5" style="padding: 15px; border-radius: 8px;">
    <p><strong>Vendedor:</strong> <?= $sale["user_name"] ?></p>
    <p><strong>Fecha:</strong> <?= $sale["created_at"] ?></p>
    <p><strong>Total:</strong> <b>L. <?= number_format($sale["total"], 2) ?></b></p>
</div>

<!-- TABLA DE PRODUCTOS -->
<table class="striped highlight centered">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($items as $item): ?>

            <?php
                // Compatibilidad con diferentes estructuras de índices
                $product  = $item["product_name"] ?? $item["name"] ?? "Sin nombre";
                $qty      = $item["qty"] ?? $item["quantity"] ?? 0;
                $price    = $item["price"] ?? 0;
                $subtotal = $qty * $price;
            ?>

            <tr>
                <td><?= $product ?></td>
                <td><?= $qty ?></td>
                <td>L. <?= number_format($price, 2) ?></td>
                <td><strong>L. <?= number_format($subtotal, 2) ?></strong></td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>
