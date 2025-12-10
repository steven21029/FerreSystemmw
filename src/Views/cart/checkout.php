<link rel="stylesheet" href="/FerreSystem/public/css/checkout.css">

<div class="checkout-container">

    <h4 class="checkout-title">Confirmar Compra</h4>

    <a href="?controller=cart&action=index" class="btn-checkout btn-back">← Volver</a>

    <br><br>

    <table class="checkout-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            <?php 
            $total = 0;
            foreach ($cart as $id => $item):
                $sub = $item["qty"] * $item["price"];
                $total += $sub;
            ?>
            <tr>
                <td><?= htmlspecialchars($item["name"]) ?></td>
                <td><?= $item["qty"] ?></td>
                <td>L. <?= number_format($item["price"], 2) ?></td>
                <td>L. <?= number_format($sub, 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p class="checkout-total">Total: L. <?= number_format($total, 2) ?></p>

    <a href="#" id="btn-efectivo" class="btn-checkout btn-finish">
        Finalizar Compra (Efectivo)
    </a>

    <br><br>

    <h3>Métodos de Pago</h3>

    <div class="payment-methods">
        <a href="?controller=checkout&action=start" class="btn-paypal">
            💳 Pagar con PayPal
        </a>

        <a href="?controller=cart&action=stripeForm" class="btn-stripe">
            ⚡ Pagar con Stripe (Simulación)
        </a>
    </div>

</div>

<script src="/FerreSystem/public/js/efectivo.js"></script>