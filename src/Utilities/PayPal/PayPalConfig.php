<?php

// =======================================
// CARGAR VARIABLES DESDE .env (Dotenv)
// =======================================

require_once __DIR__ . '/../../../vendor/autoload.php';

use Dotenv\Dotenv;

// Ruta correcta a la carpeta raíz del proyecto
$dotenv = Dotenv::createImmutable(__DIR__ . "/../../../");
$dotenv->load();


// =======================================
// DEFINIR CONSTANTES SOLO SI NO EXISTEN
// =======================================

// CLIENT_ID
if (!defined("PAYPAL_CLIENT_ID")) {
    define("PAYPAL_CLIENT_ID", $_ENV["PAYPAL_CLIENT_ID"] ?? "");
}

// SECRET
if (!defined("PAYPAL_CLIENT_SECRET")) {
    define("PAYPAL_CLIENT_SECRET", $_ENV["PAYPAL_CLIENT_SECRET"] ?? "");
}

// SANDBOX o LIVE
if (!defined("PAYPAL_ENVIRONMENT")) {
    define("PAYPAL_ENVIRONMENT", $_ENV["PAYPAL_ENV"] ?? "sandbox");
}

// Moneda
if (!defined("PAYPAL_CURRENCY")) {
    define("PAYPAL_CURRENCY", $_ENV["PAYPAL_CURRENCY"] ?? "USD");
}

