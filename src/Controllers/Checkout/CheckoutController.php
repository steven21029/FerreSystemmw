<?php

namespace Controllers\Checkout;

use Utilities\PayPal\PayPalOrder;
use Utilities\PayPal\PayPalRestApi;

require_once __DIR__ . "/../../Utilities/PayPal/PayPalConfig.php";

class CheckoutController
{
    private function requireLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["user"])) {
            $_SESSION["error"] = "Debe iniciar sesión.";
            header("Location: ?controller=auth&action=login");
            exit;
        }
    }

    // INICIO DEL PAGO CON PAYPAL

    public function start()
    {
        $this->requireLogin();

        // Verificar carrito
        $cart = $_SESSION["cart"] ?? [];

        if (empty($cart)) {
            $_SESSION["error"] = "El carrito está vacío.";
            header("Location: ?controller=cart&action=index");
            exit;
        }

        // Crear orden PayPal
        $order = new PayPalOrder(
            "ORD-" . time(),
            "http://localhost/FerreSystem/public/index.php?controller=checkout&action=cancel",
            "http://localhost/FerreSystem/public/index.php?controller=checkout&action=accept"
        );

        // Agregar cada producto del carrito a la orden
        foreach ($cart as $id => $item) {
            $order->addItem(
                $item["name"],
                "Compra en FerreSystem",
                (string)$id,
                number_format($item["price"], 2, ".", ""),
                0,
                $item["qty"],
                "PHYSICAL_GOODS"
            );
        }

        // Crear cliente PayPal API
        $paypal = new PayPalRestApi(
            PAYPAL_CLIENT_ID,
            PAYPAL_CLIENT_SECRET,
            PAYPAL_ENVIRONMENT
        );

        $paypal->getAccessToken();

        // Crear orden real en PayPal
        $response = $paypal->createOrder($order);

        if (!isset($response->id)) {
            echo "<pre>Error creando la orden PayPal:\n";
            print_r($response);
            exit;
        }

        $_SESSION["paypal_order_id"] = $response->id;

        // Buscar link de aprobación
        foreach ($response->links as $lnk) {
            if ($lnk->rel == "approve") {
                header("Location: " . $lnk->href);
                exit;
            }
        }

        echo "Error: PayPal no devolvió un link de aprobación.";
    }

    // CUANDO EL PAGO FUE APROBADO
   
    public function accept()
    {
        $this->requireLogin();

        $orderId = $_SESSION["paypal_order_id"] ?? null;

        if (!$orderId) {
            echo "No existe una orden activa para capturar.";
            exit;
        }

        // Cliente PayPal API
        $paypal = new PayPalRestApi(
            PAYPAL_CLIENT_ID,
            PAYPAL_CLIENT_SECRET,
            PAYPAL_ENVIRONMENT
        );

        // Capturar la orden (cobro final)
        $result = $paypal->captureOrder($orderId);

        // Guardar JSON para mostrar en la vista
        $orderJson = json_encode($result, JSON_PRETTY_PRINT);

        // Render de recibo
        ob_start();
        $orderjson = $orderJson;
        require __DIR__ . "/../../Views/cart/accept.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    // CUANDO EL USUARIO CANCELA EL PAGO
    
    public function cancel()
    {
        $this->requireLogin();

        ob_start();
        require __DIR__ . "/../../Views/cart/error.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }
}
