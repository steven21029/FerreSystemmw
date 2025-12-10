<link rel="stylesheet" href="/FerreSystem/public/css/roles.css">

<h2 class="titulo-page">Relación Roles - Funciones</h2>

<div class="tabla-contenedor">

    <table class="tabla-registros">
        <thead>
            <tr>
                <th>ID</th>
                <th>Rol</th>
                <th>Función</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($roleFunctions as $rf): ?>
            <tr>
                <td><?= $rf["id"] ?></td>
                <td><?= $rf["role_name"] ?></td>
                <td><?= $rf["function_name"] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
