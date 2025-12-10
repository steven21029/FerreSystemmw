<h2 style="margin-bottom: 20px;">Relación Usuarios - Roles</h2>

<table class="table table-striped table-bordered" style="width: 80%; margin: auto; text-align:center;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Rol</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($userRoles as $ur): ?>
            <tr>
                <td><?= $ur["id"] ?></td>
                <td><?= $ur["user_name"] ?></td>
                <td><?= $ur["role_name"] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br>

<div style="text-align:center;">
    <a href="?controller=home&action=index" class="btn grey">← Volver</a>
</div>
