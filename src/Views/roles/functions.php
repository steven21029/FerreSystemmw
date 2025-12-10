<link rel="stylesheet" href="/FerreSystem/public/css/roles.css">

<h2 class="titulo-page">Funciones del Rol: <?= $role['name'] ?></h2>

<!-- ============================
      FORMULARIO PARA AGREGAR
=============================== -->
<div class="card-form">
    <h3 class="subtitulo">Agregar Función</h3>

    <form method="POST" action="?controller=role&action=addFunction" class="form-agregar">

        <input type="hidden" name="role_id" value="<?= $role['id'] ?>">

        <label for="function_id">Seleccione una función:</label>
        <select id="function_id" name="function_id" class="select-input" required>
            <?php foreach ($functions as $f): ?>
                <option value="<?= $f['id'] ?>"><?= $f['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn-primary">Agregar</button>
    </form>
</div>

<!-- ============================
      TABLA DE FUNCIONES ASIGNADAS
=============================== -->
<h3 class="subtitulo" style="margin-top: 30px;">Funciones Asignadas</h3>

<div class="tabla-contenedor">
    <table class="tabla-registros">
        <thead>
            <tr>
                <th>ID</th>
                <th>Función</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($assigned as $a): ?>
            <tr>
                <td><?= $a["id"] ?></td>
                <td><?= $a["name"] ?></td>

                <td>
                    <a class="btn-danger btn-sm"
                       href="?controller=role&action=removeFunction&id=<?= $a['id'] ?>&role_id=<?= $role['id'] ?>">
                        Quitar
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
