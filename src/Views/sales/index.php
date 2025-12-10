<h4>Historial de Ventas</h4>

<a href="index.php?controller=home&action=index" class="btn grey">← Volver</a>
<br><br>

<?php if (empty($sales)): ?>
    <div class="card-panel yellow lighten-4">
        No hay ventas registradas.
    </div>
<?php else: ?>

<table class="striped highlight centered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Vendedor</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Detalles</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($sales as $s): ?>
        <tr>
            <td><?= $s["id"] ?></td>
            <td><?= $s["user_name"] ?></td>
            <td>
                <strong>L. <?= number_format($s["total"], 2) ?></strong>
            </td>
            <td><?= $s["created_at"] ?></td>

            <td>
                <a href="index.php?controller=sale&action=show&id=<?= $s['id'] ?>" 
                   class="btn-small blue">
                    Ver
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>
