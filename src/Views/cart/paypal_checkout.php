<h4>Procesar Pago con PayPal</h4>

<?php
$total = 0;
foreach ($cart as $item) {
    $total += $item["qty"] * $item["price"];
}
?>

<p><strong>Total a pagar:</strong> L. <?= number_format($total, 2) ?></p>

<form method="POST" action="?controller=cart&action=paypalTest">
    <button class="btn btn-primary">Pagar con PayPal</button>
</form>

<a href="?controller=cart&action=index" class="btn btn-secondary">Cancelar</a>
