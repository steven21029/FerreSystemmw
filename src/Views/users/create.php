<h2>Crear Usuario</h2>

<form method="POST" action="?controller=user&action=store">

    <label>Nombre:</label>
    <input type="text" name="name" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Contraseña:</label>
    <input type="password" name="password" required>

    <button type="submit">Guardar</button>
</form>
