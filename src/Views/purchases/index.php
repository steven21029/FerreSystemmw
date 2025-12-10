<link rel="stylesheet" href="/FerreSystem/public/css/purchases.css">

<h2 class="titulo-page">Historial de Compras</h2>

<a href="index.php?controller=home&action=index" class="btn-back">
    ← Volver
</a>

<br><br>

<table class="tabla-registros">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Total</th>
            <th>Fecha</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($purchases as $p): ?>
        <tr>
            <td><?= $p["id"] ?></td>
            <td><?= $p["user_name"] ?></td>
            <td>L. <?= number_format($p["total"], 2) ?></td>
            <td><?= $p["created_at"] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
