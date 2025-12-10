<?php

namespace Controllers\Checkout;

class ErrorController
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

    public function index()
    {
        $this->requireLogin();

        ob_start();
        require __DIR__ . "/../../Views/checkout/error.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }
}
