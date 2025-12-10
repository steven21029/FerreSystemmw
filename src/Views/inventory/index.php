<link rel="stylesheet" href="/FerreSystem/public/css/inventory.css">

<div class="page-container">

    <h2 class="page-title">Inventario</h2>

    <a href="?controller=inventory&action=create" class="btn-primary btn-new">
        + Nueva entrada
    </a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($inventory as $i): ?>
            <tr>
                <td><?= $i["id"] ?></td>
                <td><?= $i["product_name"] ?></td>

                <td class="<?= ($i['quantity'] < 0) ? 'text-negative' : '' ?>">
                    <?= $i["quantity"] ?>
                </td>

                <td>
                    <a href="?controller=inventory&action=edit&id=<?= $i['id'] ?>" 
                       class="btn-small btn-edit">
                       Editar
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
