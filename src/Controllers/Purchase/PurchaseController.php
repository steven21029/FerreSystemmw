<?php

namespace Controllers\Purchase;

use DAO\Purchase\PurchaseDAO;
use DAO\PurchaseItem\PurchaseItemDAO;
use DAO\Product\ProductDAO;
use DAO\Inventory\InventoryDAO;

class PurchaseController
{
    public function index()
    {
        session_start();

        $dao = new PurchaseDAO();
        $purchases = $dao->getAll();

        $title = "Historial de Compras";

        ob_start();
        require __DIR__ . "/../../Views/purchases/index.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    public function create()
    {
        session_start();

        $products = (new ProductDAO())->getAll();
        $title = "Registrar Compra";

        ob_start();
        require __DIR__ . "/../../Views/purchases/create.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    public function store()
    {
        session_start();

        // =============================
        // VALIDACIÓN BÁSICA
        // =============================
        if (empty($_POST["items"]) || empty($_POST["total"])) {
            $_SESSION["error"] = "Datos incompletos.";
            header("Location: ?controller=purchase&action=create");
            exit;
        }

        $items = $_POST["items"];
        $total = floatval($_POST["total"]);

        if ($total <= 0) {
            $_SESSION["error"] = "El total debe ser mayor que cero.";
            header("Location: ?controller=purchase&action=create");
            exit;
        }

        $userId = $_SESSION["user"]["id"];

        $purchaseDAO  = new PurchaseDAO();
        $itemDAO      = new PurchaseItemDAO();
        $productDAO   = new ProductDAO();
        $inventoryDAO = new InventoryDAO();

        // =============================
        // CREAR COMPRA
        // =============================
        $purchaseId = $purchaseDAO->create($userId, $total);

        // =============================
        // PROCESAR CADA PRODUCTO
        // =============================
        foreach ($items as $i) {

            // Guardar detalle de compra
            $itemDAO->saveItem($purchaseId, $i["id"], $i["qty"], $i["price"]);

            // Actualizar stock
            $product = $productDAO->getById($i["id"]);
            $newStock = intval($product["stock"]) + intval($i["qty"]);
            $productDAO->updateStock($i["id"], $newStock);

            // Movimiento en inventario (ENTRADA)
            $inventoryDAO->addMovement(
                $i["id"],
                intval($i["qty"]),
                "ENTRADA",
                "Compra #$purchaseId"
            );
        }

        // =============================
        // REDIRECCIÓN FINAL
        // =============================
        header("Location: ?controller=purchase&action=index");
        exit;
    }
}
