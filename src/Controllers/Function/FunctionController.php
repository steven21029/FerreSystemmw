<?php

namespace Controllers\Function;

use DAO\Function\FunctionDAO;

class FunctionController
{
    private function allowOnlyAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["user"])) {
            $_SESSION["error"] = "Debe iniciar sesión.";
            header("Location: ?controller=auth&action=login");
            exit;
        }

        if ($_SESSION["user"]["role"] !== "admin") {
            $_SESSION["error"] = "Acceso denegado.";
            header("Location: ?controller=home&action=index");
            exit;
        }
    }

    public function index()
    {
        $this->allowOnlyAdmin();

        $dao = new FunctionDAO();
        $functions = $dao->getAll();

        $title = "Funciones del Sistema";

        ob_start();
        require __DIR__ . "/../../Views/functions/index.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }
}
