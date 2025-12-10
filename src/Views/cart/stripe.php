<link rel="stylesheet" href="/FerreSystem/public/css/payment.css">

<div class="pay-container">

    <div class="pay-card">
        
        <h2 class="pay-title stripe-title">Pago Simulado con Stripe</h2>
        <p class="pay-subtitle">Esto es solo una simulación de pago (no es real).</p>

        <img src="/FerreSystem/public/img/stripe.png" class="pay-logo" alt="Stripe">

        <div class="pay-info">
            <p><strong>Método:</strong> Stripe</p>
            <p><strong>Estado:</strong> Aprobado ✔</p>
        </div>

        <!-- CONFIRMAR (registra la venta real en tu sistema) -->
        <a href="?controller=cart&action=store" class="btn-stripe">
            Confirmar Pago Simulado
        </a>

        <!-- VOLVER AL CHECKOUT -->
        <a href="?controller=cart&action=checkout" class="btn-back">
            ← Cancelar y volver
        </a>

    </div>

</div>
