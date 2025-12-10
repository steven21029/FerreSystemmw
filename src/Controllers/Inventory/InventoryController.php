<?php

namespace Controllers\Inventory;

use DAO\Inventory\InventoryDAO;
use DAO\Product\ProductDAO;

class InventoryController
{
    private function requireAdminOrBodega()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        if (!isset($_SESSION["user"])) {
            $_SESSION["error"] = "Debe iniciar sesión.";
            header("Location: ?controller=auth&action=login");
            exit;
        }

        // Solo ADMIN o BODEGA pueden tocar inventario
        if (!in_array($_SESSION["user"]["role"], ["admin", "bodega"])) {
            $_SESSION["error"] = "Acceso denegado.";
            header("Location: ?controller=home&action=index");
            exit;
        }
    }

    public function index()
    {
        $this->requireAdminOrBodega();

        $dao = new InventoryDAO();
        $inventory = $dao->getAll();
        $title = "Inventario";

        ob_start();
        require __DIR__ . "/../../Views/inventory/index.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    public function create()
    {
        $this->requireAdminOrBodega();

        $productDAO = new ProductDAO();
        $products = $productDAO->getAll();
        $title = "Nueva entrada de inventario";

        ob_start();
        require __DIR__ . "/../../Views/inventory/create.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    public function store()
    {
        $this->requireAdminOrBodega();

        if (empty($_POST["product_id"]) || empty($_POST["quantity"])) {
            $_SESSION["error"] = "Datos incompletos.";
            header("Location: ?controller=inventory&action=create");
            exit;
        }

        $productId = intval($_POST["product_id"]);
        $quantity  = intval($_POST["quantity"]);

        if ($quantity == 0) {
            $_SESSION["error"] = "La cantidad no puede ser cero.";
            header("Location: ?controller=inventory&action=create");
            exit;
        }

        $inventoryDAO = new InventoryDAO();
        $productDAO   = new ProductDAO();

        // Registrar movimiento
        $inventoryDAO->addMovement(
            $productId,
            $quantity,
            "ENTRADA",
            null
        );

        // Actualizar stock del producto
        $product = $productDAO->getById($productId);
        $newStock = intval($product["stock"]) + $quantity;
        $productDAO->updateStock($productId, $newStock);

        header("Location: ?controller=inventory&action=index");
        exit;
    }

    public function edit()
    {
        $this->requireAdminOrBodega();

        if (!isset($_GET["id"])) {
            $_SESSION["error"] = "ID no proporcionado.";
            header("Location: ?controller=inventory&action=index");
            exit;
        }

        $id = intval($_GET["id"]);

        $dao = new InventoryDAO();
        $item = $dao->getById($id);

        if (!$item) {
            $_SESSION["error"] = "Registro no encontrado.";
            header("Location: ?controller=inventory&action=index");
            exit;
        }

        $title = "Editar inventario";

        ob_start();
        require __DIR__ . "/../../Views/inventory/edit.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    public function update()
    {
        $this->requireAdminOrBodega();

        if (!isset($_POST["id"]) || !isset($_POST["quantity"])) {
            $_SESSION["error"] = "Datos incompletos.";
            header("Location: ?controller=inventory&action=index");
            exit;
        }

        $id     = intval($_POST["id"]);
        $extra  = intval($_POST["quantity"]);

        if ($extra == 0) {
            $_SESSION["error"] = "La cantidad no puede ser cero.";
            header("Location: ?controller=inventory&action=index");
            exit;
        }

        $inventoryDAO = new InventoryDAO();
        $productDAO   = new ProductDAO();

        $item = $inventoryDAO->getById($id);

        if (!$item) {
            $_SESSION["error"] = "Registro no encontrado.";
            header("Location: ?controller=inventory&action=index");
            exit;
        }

        // Nueva cantidad del movimiento
        $newQuantity = intval($item["quantity"]) + $extra;
        $inventoryDAO->updateQuantity($id, $newQuantity);

        // Actualizar stock del producto
        $product = $productDAO->getById($item["product_id"]);
        $newStock = intval($product["stock"]) + $extra;
        $productDAO->updateStock($item["product_id"], $newStock);

        header("Location: ?controller=inventory&action=index");
        exit;
    }
}
