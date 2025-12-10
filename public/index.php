<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

$controller = $_GET["controller"] ?? "auth";
$action     = $_GET["action"] ?? null;

$defaultActions = [
    "inventory"    => "index",
    "product"      => "index",
    "cart"         => "index",
    "sale"         => "index",
    "home"         => "index",
    "report"       => "index",
    "purchase"     => "index",
    "role"         => "index",
    "roleFunction" => "index",
    "userRole"     => "index",
    "user"         => "index",
    "checkout"     => "start",
];

if (isset($defaultActions[$controller])) {
    $action = $action ?? $defaultActions[$controller];
} else {
    $action = $action ?? "login";
}

$publicRoutes = [
    "auth/login",
    "auth/doLogin"
];

$currentRoute = "$controller/$action";

// PROTECCIÓN DE RUTAS
if (!in_array($currentRoute, $publicRoutes)) {

    if (empty($_SESSION["user"])) {
        header("Location: ?controller=auth&action=login");
        exit;
    }

    if (empty($_SESSION["user"]["role"])) {
        $_SESSION["user"]["role"] = "cliente";
    }

    if ($_SESSION["user"]["active"] == 0) {
        session_destroy();
        header("Location: ?controller=auth&action=login");
        exit;
    }
}

$map = [
    "auth"         => "Controllers\\Auth\\AuthController",
    "home"         => "Controllers\\Home\\HomeController",
    "user"         => "Controllers\\User\\UserController",
    "userRole"     => "Controllers\\UserRole\\UserRoleController",
    "role"         => "Controllers\\Role\\RoleController",
    "roleFunction" => "Controllers\\RoleFunction\\RoleFunctionController",
    "function"     => "Controllers\\Function\\FunctionController",
    "product"      => "Controllers\\Product\\ProductController",
    "inventory"    => "Controllers\\Inventory\\InventoryController",
    "purchase"     => "Controllers\\Purchase\\PurchaseController",
    "sale"         => "Controllers\\Sale\\SaleController",
    "cart"         => "Controllers\\Cart\\CartController",
    "report"       => "Controllers\\Report\\ReportController",
    "checkout"     => "Controllers\\Checkout\\CheckoutController",
];

$controllerName = $map[$controller] ?? null;

if ($controllerName && class_exists($controllerName)) {

    $obj = new $controllerName();

    if (method_exists($obj, $action)) {
        $obj->$action();
    } else {
        echo "Acción '$action' no encontrada.";
    }

} else {
    echo "Controlador '$controllerName' no encontrado.";
}
