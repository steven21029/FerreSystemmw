<h2>Funciones del Sistema</h2>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Función</th>
            <th>Activo</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($functions as $f): ?>
            <tr>
                <td><?= $f["id"] ?></td>
                <td><?= $f["name"] ?></td>
                <td><?= $f["active"] ? "✔" : "✖" ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
