<h4>Registrar Venta</h4>

<a href="index.php?controller=sale&action=index" class="btn grey">← Volver</a>
<br><br>

<form action="index.php?controller=sale&action=store" method="POST">

    <table class="striped">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Venta</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($products as $p): ?>
            <tr>
                <td><?= $p["name"] ?></td>

                <td>
                    <input type="number" 
                           name="items[<?= $p['id'] ?>][qty]" 
                           min="0" 
                           value="0">
                </td>

                <td>
                    <input type="number" 
                           name="items[<?= $p['id'] ?>][price]" 
                           min="0" 
                           step="0.01" 
                           value="<?= $p['price'] ?>">
                </td>

                <input type="hidden" 
                       name="items[<?= $p['id'] ?>][id]" 
                       value="<?= $p['id'] ?>">

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <label>Total:</label>
    <input type="number" name="total" required min="0" step="0.01">

    <button type="submit" class="btn blue">Registrar Venta</button>

</form>
