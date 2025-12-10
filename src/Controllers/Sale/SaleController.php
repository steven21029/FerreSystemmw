<?php

namespace Controllers\Sale;

use DAO\Sale\SaleDAO;
use DAO\SaleItem\SaleItemDAO;
use DAO\Product\ProductDAO;
use DAO\Inventory\InventoryDAO;
use DAO\Kardex\KardexDAO;

class SaleController 
{
    /* ==========================================
       VALIDAR SESIÓN ACTIVA
    ========================================== */
    private function allowLogged()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION["user"])) {
            $_SESSION["error"] = "Debe iniciar sesión.";
            header("Location: ?controller=auth&action=login");
            exit;
        }
    }

    /* ==========================================
       LISTADO DE VENTAS
    ========================================== */
    public function index() 
    {
        $this->allowLogged();

        $dao = new SaleDAO();

        // Si es cliente → solo sus ventas
        if ($_SESSION["user"]["role"] === "cliente") {
            $sales = $dao->getSalesByUser($_SESSION["user"]["id"]);
        } else {
            $sales = $dao->getAll();
        }

        $title = "Ventas";

        ob_start();
        require __DIR__ . "/../../Views/sales/index.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    /* ==========================================
       FORMULARIO NUEVA VENTA
    ========================================== */
    public function create() 
    {
        $this->allowLogged();

        $products = (new ProductDAO())->getAll();
        $title = "Registrar Venta";

        ob_start();
        require __DIR__ . "/../../Views/sales/create.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    /* ==========================================
       GUARDAR VENTA
    ========================================== */
    public function store() 
    {
        $this->allowLogged();

        if (empty($_POST["items"]) || empty($_POST["total"])) {
            $_SESSION["error"] = "Datos de venta incompletos.";
            header("Location: ?controller=sale&action=create");
            exit;
        }

        $userId = $_SESSION["user"]["id"];
        $items = $_POST["items"];
        $total = floatval($_POST["total"]);

        $saleDAO      = new SaleDAO();
        $itemDAO      = new SaleItemDAO();
        $productDAO   = new ProductDAO();
        $inventoryDAO = new InventoryDAO();
        $kardexDAO    = new KardexDAO();

        // Crear la venta
        $saleId = $saleDAO->create($userId, $total);

        foreach ($items as $i) 
        {
            if ($i["qty"] > 0) 
            {
                $producto = $productDAO->getById($i["id"]);

                if (!$producto) {
                    continue; // El producto fue eliminado o no existe
                }

                // Validar stock disponible
                if ($producto["stock"] < $i["qty"]) {
                    $_SESSION["error"] = "Stock insuficiente para: " . $producto["name"];
                    header("Location: ?controller=sale&action=create");
                    exit;
                }

                // Guardar detalle de venta
                $itemDAO->saveItem($saleId, $i["id"], $i["qty"], $i["price"]);

                // Actualizar stock
                $stockAnterior = $producto["stock"];
                $stockNuevo = $stockAnterior - $i["qty"];
                $productDAO->updateStock($i["id"], $stockNuevo);

                // Registrar en INVENTORY
                $inventoryDAO->addMovement(
                    $i["id"],
                    -$i["qty"],
                    "SALIDA",
                    $saleId
                );

                // Registrar en KARDEX
                $kardexDAO->registrarMovimiento(
                    $i["id"],
                    "SALIDA",
                    $i["qty"],
                    $stockAnterior,
                    $stockNuevo,
                    "Venta #$saleId",
                    $userId
                );
            }
        }

        header("Location: ?controller=sale&action=index");
        exit;
    }

    /* ==========================================
       DETALLE DE UNA VENTA
    ========================================== */
    public function show() 
    {
        $this->allowLogged();

        if (!isset($_GET["id"])) {
            $_SESSION["error"] = "ID no proporcionado.";
            header("Location: ?controller=sale&action=index");
            exit;
        }

        $id = intval($_GET["id"]);

        $dao     = new SaleDAO();
        $itemDao = new SaleItemDAO();

        $sale = $dao->getById($id);

        if (!$sale) {
            $_SESSION["error"] = "Venta no encontrada.";
            header("Location: ?controller=sale&action=index");
            exit;
        }

        $items = $itemDao->getBySaleId($id);

        $title = "Detalle de Venta #$id";

        ob_start();
        require __DIR__ . "/../../Views/sales/show.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }
}
