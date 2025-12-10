<link rel="stylesheet" href="/FerreSystem/public/css/payment.css">

<div class="pay-container">

    <div class="pay-card">

        <h2 class="pay-title stripe-title">Pago con Tarjeta (Simulación)</h2>
        <p class="pay-subtitle">Ingrese los datos de la tarjeta para procesar el pago simulado.</p>

        <form action="?controller=cart&action=stripePay" method="POST">

            <div class="form-group">
                <label>Número de tarjeta</label>
                <input type="text" name="card_number" maxlength="16" required class="input-field">
            </div>

            <div class="form-group">
                <label>Nombre en la tarjeta</label>
                <input type="text" name="card_name" required class="input-field">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Expiración (MM/YY)</label>
                    <input type="text" name="card_exp" maxlength="5" required class="input-field">
                </div>

                <div class="form-group">
                    <label>CVC</label>
                    <input type="text" name="card_cvc" maxlength="4" required class="input-field">
                </div>
            </div>

            <button type="submit" class="btn-stripe">
                Procesar Pago Simulado
            </button>

        </form>

        <a href="?controller=cart&action=checkout" class="btn-back">
            ← Cancelar y volver
        </a>

    </div>

</div>

<style>
.input-field {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-top: 5px;
}
.form-group {
    margin-bottom: 15px;
    text-align: left;
}
.form-row {
    display: flex;
    gap: 10px;
}
</style>
