<?php

namespace Controllers\RoleFunction;

use DAO\RoleFunction\RoleFunctionDAO;

class RoleFunctionController
{

    private function allowOnlyAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION["user"])) {
            $_SESSION["error"] = "Debe iniciar sesión.";
            header("Location: ?controller=auth&action=login");
            exit;
        }

        if (($_SESSION["user"]["role"] ?? "") !== "admin") {
            $_SESSION["error"] = "Acceso denegado.";
            header("Location: ?controller=home&action=index");
            exit;
        }
    }

    public function index()
    {
        $this->allowOnlyAdmin();

        $dao = new RoleFunctionDAO();
        $roleFunctions = $dao->getAll();

        $title = "Relación Roles - Funciones";

        ob_start();
        require __DIR__ . "/../../Views/role_functions/index.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }
}
