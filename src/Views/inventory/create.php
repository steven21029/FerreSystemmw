<link rel="stylesheet" href="/FerreSystem/public/css/inventory.css">

<div class="form-container">

    <h2 class="form-title">Nueva Entrada de Inventario</h2>

    <form action="?controller=inventory&action=store" method="POST" class="form">

        <label for="product_id">Producto</label>
        <select name="product_id" id="product_id" required>
            <option value="">Seleccione...</option>

            <?php foreach ($products as $p): ?>
                <option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="quantity">Cantidad</label>
        <input type="number" id="quantity" name="quantity" min="1" required>

        <label for="note">Nota (opcional)</label>
        <input type="text" id="note" name="note">

        <div class="form-actions">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="?controller=inventory" class="btn-back">Volver</a>
        </div>

    </form>

</div>
