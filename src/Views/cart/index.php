<link rel="stylesheet" href="/FerreSystem/public/css/cart.css">

<div class="cart-container">

    <h4 class="cart-title">Carrito de Compras</h4>

    <?php if (empty($cart)): ?>
        
        <p>No hay productos en el carrito.</p>

        <br>
        <a href="?controller=product&action=index" class="btn-back btn-empty-cart">
            ← Regresar a Productos
        </a>

    <?php else: ?>

        <table class="cart-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($cart as $id => $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item["name"]) ?></td>
                    <td><?= $item["qty"] ?></td>
                    <td>L. <?= number_format($item["price"], 2) ?></td>
                    <td>L. <?= number_format($item["qty"] * $item["price"], 2) ?></td>
                    <td>
                        <a href="?controller=cart&action=remove&id=<?= $id ?>" 
                           class="btn-cart btn-remove">
                            Eliminar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- BARRA DE ACCIONES -->
        <div class="cart-actions-bar">
            <a href="?controller=product&action=index" class="btn-back">
                Seguir comprando
            </a>

            <div class="right-buttons">
                <a href="?controller=cart&action=clear" class="btn-cart btn-clear">
                    Vaciar Carrito
                </a>
            </div>
        </div>

       <!-- MÉTODOS DE PAGO INTEGRADOS -->
<div class="pay-methods">
    <p class="pay-title">Métodos de Pago Disponibles</p>

    <div class="pay-grid">

        <!-- PAYPAL (CORREGIDO) -->
        <div class="pay-card">
            <a href="?controller=checkout&action=start">
                <img src="/FerreSystem/public/img/paypal.png" class="pay-icon">
                <p>Pagar con PayPal</p>
            </a>
        </div>

        <!-- STRIPE -->
        <div class="pay-card">
            <a href="?controller=cart&action=stripeTest">
                <img src="/FerreSystem/public/img/stripe.png" class="pay-icon">
                <p>Tarjeta de Crédito (Stripe)</p>
            </a>
        </div>

        <!-- EFECTIVO -->
        <div class="pay-card">
            <a href="?controller=cart&action=checkout">
                <img src="/FerreSystem/public/img/efectivo.png" class="pay-icon">
                <p>Efectivo</p>
            </a>
                 </div>
              </div>
           </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

</div>
