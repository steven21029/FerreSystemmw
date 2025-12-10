<h2 class="title-page">Usuarios</h2>

<a class="btn-primary create-btn" href="?controller=user&action=create">
    ➕ Crear usuario
</a>

<div class="table-container">
    <table class="styled-table">

        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u["id"] ?></td>
                <td><?= $u["name"] ?></td>
                <td><?= $u["email"] ?></td>

                <td>
                    <?php if ($u["active"]): ?>
                        <span class="badge active">✔ Activo</span>
                    <?php else: ?>
                        <span class="badge inactive">✖ Inactivo</span>
                    <?php endif; ?>
                </td>

                <td class="actions">
                    <a class="action-btn edit" href="?controller=user&action=edit&id=<?= $u['id'] ?>">
                        ✏ Editar
                    </a>

                    <a class="action-btn roles" href="?controller=user&action=roles&id=<?= $u['id'] ?>">
                        🛡 Roles
                    </a>

                    <?php if ($u["active"]): ?>
                        <a class="action-btn danger" href="?controller=user&action=deactivate&id=<?= $u['id'] ?>">
                            🚫 Desactivar
                        </a>
                    <?php else: ?>
                        <a class="action-btn activate" href="?controller=user&action=activate&id=<?= $u['id'] ?>">
                            ✔ Activar
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>

<style>
.title-page {
    margin-bottom: 15px;
}

.create-btn {
    margin-bottom: 15px;
    display: inline-block;
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
    margin-right: 8px;
    text-decoration: none;
}

.action-btn {
    padding: 6px 10px;
    border-radius: 5px;
    font-size: 14px;
}

.edit { background: #4caf50; color: #fff; }
.roles { background: #607d8b; color: #fff; }
.danger { background: #e53935; color: #fff; }
.activate { background: #43a047; color: #fff; }

.badge {
    padding: 4px 8px;
    border-radius: 5px;
    font-size: 13px;
}

.active { background: #4caf50; color: white; }
.inactive { background: #f44336; color: white; }
</style>
