<h2 style="margin-bottom: 20px;">Editar Usuario</h2>

<a href="?controller=user&action=index" class="btn-back" style="margin-bottom: 15px;">
    ← Volver
</a>

<div class="form-container">

    <form method="POST" action="?controller=user&action=update" class="form-card">

        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <div class="form-group">
            <label>Nombre:</label>
            <input 
                type="text" 
                name="name" 
                value="<?= $user['name'] ?>" 
                required 
                class="input-field"
            >
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input 
                type="email" 
                name="email" 
                value="<?= $user['email'] ?>" 
                required 
                class="input-field"
            >
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-primary">Actualizar</button>
            <a href="?controller=user&action=index" class="btn-secondary">Cancelar</a>
        </div>

    </form>

</div>

<style>
.form-container {
    width: 100%;
    display: flex;
    justify-content: center;
}

.form-card {
    width: 380px;
    background: #fff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
}

.form-group {
    margin-bottom: 15px;
}

.input-field {
    width: 100%;
    padding: 8px 10px;
    margin-top: 5px;
    border: 1px solid #bbb;
    border-radius: 5px;
}

.btn-primary {
    background: #2196f3;
    padding: 8px 16px;
    border-radius: 5px;
    color: white;
}

.btn-secondary {
    background: #777;
    padding: 8px 16px;
    border-radius: 5px;
    color: white;
}

.btn-back {
    color: #2196f3;
    font-size: 15px;
}
</style>
