<link rel="stylesheet" href="/FerreSystem/public/css/reports.css">

<h2 class="titulo-page">Reporte General del Sistema</h2>

<table class="tabla-registros">
    <thead>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Stock Total</th>
            <th>Entradas</th>
            <th>Salidas</th>
            <th>Vendido</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['producto'] ?></td>
            <td><?= $row['categoria'] ?></td>
            <td>L. <?= number_format($row['precio'], 2) ?></td>

            <td><?= $row['stock_total'] ?></td>
            <td><?= $row['total_entradas'] ?></td>
            <td><?= $row['total_salidas'] ?></td>
            <td><?= $row['total_vendido'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="?controller=report&action=index" class="btn-back">← Volver</a>
