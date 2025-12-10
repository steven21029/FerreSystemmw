<?php

namespace Controllers\Cart;

use DAO\Sale\SaleDAO;
use DAO\SaleItem\SaleItemDAO;
use DAO\Product\ProductDAO;
use DAO\Inventory\InventoryDAO;
use DAO\Kardex\KardexDAO;

class CartController
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

    // MOSTRAR CARRITO

    public function index()
    {
        $this->requireLogin();

        $cart = $_SESSION["cart"] ?? [];

        ob_start();
        require __DIR__ . "/../../Views/cart/index.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    // AGREGAR PRODUCTO

    public function add()
    {
        $this->requireLogin();

        $id    = $_POST["id"] ?? null;
        $name  = $_POST["name"] ?? null;
        $price = $_POST["price"] ?? null;

        if (!$id || !$name || !$price) {
            $_SESSION["error"] = "Producto inválido.";
            header("Location: ?controller=cart&action=index");
            exit;
        }

        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }

        if (isset($_SESSION["cart"][$id])) {
            $_SESSION["cart"][$id]["qty"]++;
        } else {
            $_SESSION["cart"][$id] = [
                "name"  => $name,
                "price" => $price,
                "qty"   => 1
            ];
        }

        header("Location: ?controller=cart&action=index");
        exit;
    }

    // ELIMINAR PRODUCTO

    public function remove()
    {
        $this->requireLogin();

        $id = $_GET["id"] ?? null;

        if ($id && isset($_SESSION["cart"][$id])) {
            unset($_SESSION["cart"][$id]);
        }

        header("Location: ?controller=cart&action=index");
        exit;
    }

    // VACIAR CARRITO

    public function clear()
    {
        $this->requireLogin();

        unset($_SESSION["cart"]);

        header("Location: ?controller=cart&action=index");
        exit;
    }

    // MOSTRAR CHECKOUT

    public function checkout()
    {
        $this->requireLogin();

        $cart = $_SESSION["cart"] ?? [];

        if (empty($cart)) {
            $_SESSION["error"] = "No hay productos en el carrito.";
            header("Location: ?controller=cart&action=index");
            exit;
        }

        ob_start();
        require __DIR__ . "/../../Views/cart/checkout.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    // FINALIZAR COMPRA (EFECTIVO)

    public function store()
    {
        $this->requireLogin();

        if (empty($_SESSION["cart"])) {
            $_SESSION["error"] = "El carrito está vacío.";
            header("Location: ?controller=cart&action=index");
            exit;
        }

        $cart   = $_SESSION["cart"];
        $userId = $_SESSION["user"]["id"];

        $saleDAO      = new SaleDAO();
        $itemDAO      = new SaleItemDAO();
        $productDAO   = new ProductDAO();
        $inventoryDAO = new InventoryDAO();
        $kardexDAO    = new KardexDAO();

        $total = 0;
        foreach ($cart as $item) {
            $total += $item["qty"] * $item["price"];
        }

        // Crear venta
        $saleId = $saleDAO->create($userId, $total);

        // Registrar productos vendidos
        foreach ($cart as $id => $item) {

            $producto = $productDAO->getById($id);
            if (!$producto) continue;

            $stockAnterior = $producto["stock"];
            $stockNuevo    = $stockAnterior - $item["qty"];

            if ($stockNuevo < 0) {
                $_SESSION["error"] = "Stock insuficiente para: {$producto['name']}";
                header("Location: ?controller=cart&action=index");
                exit;
            }

            // Registrar item vendido
            $itemDAO->saveItem($saleId, $id, $item["qty"], $item["price"]);

            // Movimiento inventario
            $inventoryDAO->addMovement(
                $id,
                -$item["qty"],
                "SALIDA",
                $saleId
            );

            // Kardex
            $kardexDAO->registrarMovimiento(
                $id,
                "SALIDA",
                $item["qty"],
                $stockAnterior,
                $stockNuevo,
                "Venta #$saleId",
                $userId
            );
        }

        unset($_SESSION["cart"]);

        header("Location: ?controller=sale&action=index");
        exit;
    }

    // FORMULARIO TARJETA (STRIPE SIMULADO)

    public function stripeForm()
    {
        $this->requireLogin();

        $cart = $_SESSION["cart"] ?? [];

        if (empty($cart)) {
            $_SESSION["error"] = "No hay productos en el carrito.";
            header("Location: ?controller=cart&action=index");
            exit;
        }

        ob_start();
        require __DIR__ . "/../../Views/cart/stripe_form.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    // PROCESAR TARJETA (SIMULADO)

    public function stripePay()
    {
        $this->requireLogin();

        // En un futuro aquí se validan los datos reales.
        header("Location: ?controller=cart&action=stripeTest");
        exit;
    }

    // VISTA DE PAGO SIMULADO STRIPE
  
    public function stripeTest()
    {
        $this->requireLogin();

        ob_start();
        require __DIR__ . "/../../Views/cart/stripe.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }
}
