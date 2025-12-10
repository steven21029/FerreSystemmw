<h2>Iniciar sesión</h2>

<?php if (!empty($_SESSION["error"])): ?>
    <p style="color:red;"><?= $_SESSION["error"]; ?></p>
    <?php unset($_SESSION["error"]); ?>
<?php endif; ?>

<form id="login-form" method="POST" action="?controller=auth&action=doLogin">

    <label for="email">Email:</label>
    <input 
        type="email" 
        id="email"
        name="email" 
        required
    >

    <label for="password">Contraseña:</label>
    <input 
        type="password" 
        id="password"
        name="password" 
        required
    >

    <button type="submit" class="btn">Ingresar</button>
</form>

<!-- VALIDACIÓN EN JS -->
<script src="/FerreSystem/public/js/login.js"></script>