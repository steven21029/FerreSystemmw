<link rel="stylesheet" href="/FerreSystem/public/css/products.css">

<div class="page-container">

    <h2 class="page-title">Editar Producto</h2>

    <div class="form-card">

        <form action="?controller=product&action=update" method="POST">

            <input type="hidden" name="id" value="<?= $product['id'] ?>">

            <div class="form-group">
                <label for="name">Nombre del producto</label>
                <input 
                    type="text"
                    id="name"
                    name="name"
                    value="<?= $product['name'] ?>"
                    required
                    class="input"
                >
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea 
                    id="description"
                    name="description"
                    class="input textarea"
                    rows="3"
                ><?= $product['description'] ?></textarea>
            </div>

            <div class="form-group">
                <label for="price">Precio</label>
                <input 
                    type="number"
                    id="price"
                    name="price"
                    step="0.01"
                    value="<?= $product['price'] ?>"
                    required
                    class="input"
                >
            </div>

            <div class="form-group">
                <label for="category_id">ID Categoría</label>
                <input 
                    type="number"
                    id="category_id"
                    name="category_id"
                    value="<?= $product['category_id'] ?>"
                    required
                    class="input"
                >
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Actualizar</button>
                <a href="?controller=product" class="btn-secondary">Volver</a>
            </div>

        </form>

    </div>

</div>
