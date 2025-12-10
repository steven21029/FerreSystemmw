<h2 class="title-page">Roles del Usuario: <?= $user['name'] ?></h2>

<!-- ============================
     FORMULARIO PARA AGREGAR ROL
=============================== -->
<div class="card-box">
    <h3>Agregar Rol</h3>

    <form method="POST" action="?controller=user&action=addRole" class="form-inline">

        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

        <select name="role_id" class="select-role" required>
            <?php foreach ($roles as $r): ?>
                <option value="<?= $r['id'] ?>"><?= $r['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn-primary">
            ➕ Agregar
        </button>

    </form>
</div>

<!-- ============================
       LISTADO DE ROLES ASIGNADOS
=============================== -->
<h3 class="subtitle">Roles Asignados</h3>

<div class="table-container">
    <table class="styled-table">

        <thead>
            <tr>
                <th>ID</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($assigned as $a): ?>
            <tr>
                <td><?= $a["id"] ?></td>
                <td><?= $a["name"] ?></td>

                <td class="actions">
                    <a class="action-btn danger"
                       href="?controller=user&action=removeRole&id=<?= $a['id'] ?>&user_id=<?= $user['id'] ?>">
                        ❌ Quitar
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>


<!-- ============================
            ESTILOS
=============================== -->
<style>

.title-page {
    margin-bottom: 20px;
}

.subtitle {
    margin-top: 20px;
}

.card-box {
    padding: 15px;
    background: #f5f5f5;
    border-radius: 8px;
    margin-bottom: 20px;
}

.form-inline {
    display: flex;
    gap: 10px;
    align-items: center;
}

.select-role {
    padding: 6px;
    border-radius: 5px;
    border: 1px solid #aaa;
}

.btn-primary {
    padding: 8px 15px;
    border-radius: 5px;
    background: #1976d2;
    color: white;
    border: none;
    cursor: pointer;
    font-weight: bold;
}

.table-container {
    width: 100%;
    overflow-x: auto;
}

.styled-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.styled-table th {
    background: #1976d2;
    color: white;
    padding: 12px;
}

.styled-table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.actions a {
    text-decoration: none;
}

.action-btn {
    padding: 6px 10px;
    border-radius: 5px;
    font-size: 14px;
}

.danger {
    background: #e53935;
    color: #fff;
}

</style>
