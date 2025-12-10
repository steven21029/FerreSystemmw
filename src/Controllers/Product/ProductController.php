<?php

namespace Controllers\Product;

use DAO\Product\ProductDAO;
use DAO\Inventory\InventoryDAO;

class ProductController
{
    private function startAndCheck()
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

    private function allowOnlyAdmin()
    {
        $this->startAndCheck();

        if (($_SESSION["user"]["role"] ?? null) !== "admin") {
            $_SESSION["error"] = "Acceso denegado.";
            header("Location: ?controller=home&action=index");
            exit;
        }
    }

    private function allowAdminOrBodega()
    {
        $this->startAndCheck();

        if (!in_array($_SESSION["user"]["role"] ?? null, ["admin", "bodega"])) {
            $_SESSION["error"] = "Acceso denegado.";
            header("Location: ?controller=home&action=index");
            exit;
        }
    }

    // =====================================================
    // LISTAR PRODUCTOS
    // =====================================================
    public function index()
    {
        $this->startAndCheck();

        $dao = new ProductDAO();
        $products = $dao->getAll();
        $title = "Productos";

        ob_start();
        require __DIR__ . "/../../Views/products/index.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    // =====================================================
    // FORMULARIO CREAR PRODUCTO
    // =====================================================
    public function create()
    {
        $this->allowOnlyAdmin();

        $title = "Nuevo Producto";

        ob_start();
        require __DIR__ . "/../../Views/products/create.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    // =====================================================
    // GUARDAR PRODUCTO
    // =====================================================
    public function store()
    {
        $this->allowOnlyAdmin();

        if (empty($_POST["name"]) || empty($_POST["price"])) {
            $_SESSION["error"] = "Complete todos los campos obligatorios.";
            header("Location: ?controller=product&action=create");
            exit;
        }

        $dao = new ProductDAO();

        $data = [
            ":name"        => trim($_POST["name"]),
            ":description" => trim($_POST["description"] ?? ""),
            ":price"       => floatval($_POST["price"]),
            ":category_id" => $_POST["category_id"] ?? null
        ];

        $dao->insert($data);

        header("Location: ?controller=product&action=index");
        exit;
    }

    // =====================================================
    // FORMULARIO EDITAR PRODUCTO
    // =====================================================
    public function edit()
    {
        $this->allowAdminOrBodega();

        if (!isset($_GET["id"])) {
            $_SESSION["error"] = "ID inválido.";
            header("Location: ?controller=product&action=index");
            exit;
        }

        $dao = new ProductDAO();
        $product = $dao->getById($_GET["id"]);

        if (!$product) {
            $_SESSION["error"] = "Producto no encontrado.";
            header("Location: ?controller=product&action=index");
            exit;
        }

        $title = "Editar Producto";

        ob_start();
        require __DIR__ . "/../../Views/products/edit.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    // =====================================================
    // ACTUALIZAR PRODUCTO
    // =====================================================
    public function update()
    {
        $this->allowAdminOrBodega();

        $productDAO   = new ProductDAO();
        $inventoryDAO = new InventoryDAO();

        $product = $productDAO->getById($_POST["id"]);

        if (!$product) {
            $_SESSION["error"] = "Producto no encontrado.";
            header("Location: ?controller=product&action=index");
            exit;
        }

        $oldStock = intval($product["stock"]);
        $newStock = intval($_POST["stock"] ?? $oldStock);

        // Actualizar producto
        $productDAO->update([
            ":id"          => $_POST["id"],
            ":name"        => trim($_POST["name"]),
            ":description" => trim($_POST["description"]),
            ":price"       => floatval($_POST["price"]),
            ":category_id" => $_POST["category_id"],
            ":stock"       => $newStock,
            ":image_url"   => trim($_POST["image_url"] ?? "")
        ]);

        // Registrar movimiento si hay diferencia
        $difference = $newStock - $oldStock;

        if ($difference != 0) {
            $inventoryDAO->addMovement(
                $_POST["id"],
                abs($difference),
                $difference > 0 ? "ENTRADA" : "SALIDA",
                "Ajuste de inventario"
            );
        }

        header("Location: ?controller=product&action=index");
        exit;
    }

    // =====================================================
    // ELIMINAR PRODUCTO
    // =====================================================
    public function delete()
    {
        $this->allowOnlyAdmin();

        if (!isset($_GET["id"])) {
            $_SESSION["error"] = "ID inválido.";
            header("Location: ?controller=product&action=index");
            exit;
        }

        $dao = new ProductDAO();
        $dao->delete($_GET["id"]);

        header("Location: ?controller=product&action=index");
        exit;
    }
}
