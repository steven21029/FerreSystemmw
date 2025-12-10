<link rel="stylesheet" href="/FerreSystem/public/css/roles.css">

<h2 class="titulo-page">Roles del Sistema</h2>

<div class="tabla-contenedor">
    <table class="tabla-registros">
        <thead>
            <tr>
                <th>ID</th>
                <th>Rol</th>
                <th>Funciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($roles as $r): ?>
            <tr>
                <td><?= $r["id"] ?></td>
                <td><?= $r["name"] ?></td>

                <td>
                    <a class="btn-config"
                       href="?controller=role&action=functions&id=<?= $r['id'] ?>">
                        ⚙ Ver funciones
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
