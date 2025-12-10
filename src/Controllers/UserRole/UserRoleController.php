<?php

namespace Controllers\UserRole;

use DAO\UserRole\UserRoleDAO;

class UserRoleController
{
    /**
     * Permitir solo ADMIN
     */
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

    /**
     * LISTADO COMPLETO DE USERS-ROLES
     */
    public function index()
    {
        $this->allowOnlyAdmin();

        $dao = new UserRoleDAO();
        $userRoles = $dao->getAll();

        $title = "Relación Usuarios – Roles";

        ob_start();
        require __DIR__ . "/../../Views/user_roles/index.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }
}
