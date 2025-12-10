<link rel="stylesheet" href="/FerreSystem/public/css/purchases.css">

<h4 class="titulo-form">Registrar Compra</h4>

<a href="index.php?controller=purchase&action=index" class="btn-back">
    ← Volver
</a>

<br><br>

<form action="index.php?controller=purchase&action=store" method="POST">

    <table class="tabla-compras">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($products as $index => $p): ?>
            <tr>
                <td><?= $p["name"] ?></td>

                <td>
                    <input 
                        type="number" 
                        name="items[<?= $index ?>][qty]" 
                        min="0" 
                        value="0"
                        class="input-num"
                    >

                    <input 
                        type="hidden" 
                        name="items[<?= $index ?>][id]" 
                        value="<?= $p["id"] ?>"
                    >
                </td>

                <td>
                    <input 
                        type="number" 
                        name="items[<?= $index ?>][price]" 
                        min="0" 
                        step="0.01" 
                        value="0"
                        class="input-num"
                    >
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total-box">
        <label>Total:</label>
        <input 
            type="number" 
            name="total" 
            required 
            min="0" 
            step="0.01"
            class="input-num"
        >
    </div>

    <button type="submit" class="btn-primary">
        Guardar Compra
    </button>

</form>
