<link rel="stylesheet" href="/FerreSystem/public/css/inventory.css">

<div class="form-container">

    <h2 class="form-title">Editar Entrada de Inventario</h2>

    <div class="form-card">
        <form action="?controller=inventory&action=update" method="POST">

            <input type="hidden" name="id" value="<?= $item['id'] ?>">

            <div class="form-group">
                <label>Producto</label>
                <input 
                    type="text" 
                    value="<?= $item['product_name'] ?>" 
                    disabled 
                    class="input-disabled"
                >
            </div>

            <div class="form-group">
                <label class="<?= ($item['quantity'] < 0) ? 'text-negative' : '' ?>">
                    Cantidad actual
                </label>

                <input 
                    type="number" 
                    value="<?= $item['quantity'] ?>" 
                    disabled 
                    class="input-current <?= ($item['quantity'] < 0) ? 'input-negative' : '' ?>"
                >
            </div>

            <div class="form-group">
                <label>Agregar cantidad</label>

                <input 
                    type="number" 
                    name="quantity"
                    placeholder="Cantidad positiva (+) o negativa (-)" 
                    required
                    class="input-edit"
                >
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-success">Guardar cambios</button>
                <a href="?controller=inventory&action=index" class="btn-back">Volver</a>
            </div>

        </form>
    </div>

</div>
