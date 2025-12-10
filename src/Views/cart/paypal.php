<link rel="stylesheet" href="/FerreSystem/public/css/payment.css">

<div class="pay-container">

    <div class="pay-card">
        
        <h2 class="pay-title">Pago Simulado con PayPal</h2>
        <p class="pay-subtitle">Esto es solo una simulación de pago (no es real).</p>

        <img src="/FerreSystem/public/img/paypal.png" class="pay-logo" alt="PayPal">

        <div class="pay-info">
            <p><strong>Método:</strong> PayPal</p>
            <p><strong>Estado:</strong> Aprobado ✔</p>
        </div>

        <!-- CONFIRMAR PAGO (registra venta real) -->
        <a href="?controller=cart&action=store" class="btn-pay">
            Confirmar Pago Simulado
        </a>

        <!-- VOLVER AL CHECKOUT -->
        <a href="?controller=cart&action=checkout" class="btn-back">
            ← Cancelar y volver
        </a>

    </div>

</div>
