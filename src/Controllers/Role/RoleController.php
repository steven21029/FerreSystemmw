<?php

namespace Controllers\Role;

use DAO\Role\RoleDAO;
use DAO\Function\FunctionDAO;
use DAO\RoleFunction\RoleFunctionDAO;


class RoleController
{
    /* ==========================================
       PERMITIR SOLO ADMINISTRADORES
    ========================================== */
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

    /* ==========================================
       LISTADO DE ROLES
    ========================================== */
    public function index()
    {
        $this->allowOnlyAdmin();

        $dao = new RoleDAO();
        $roles = $dao->getAll();

        $title = "Roles del Sistema";

        ob_start();
        require __DIR__ . "/../../Views/roles/index.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    /* ==========================================
       VER FUNCIONES ASIGNADAS A UN ROL
    ========================================== */
    public function functions()
    {
        $this->allowOnlyAdmin();

        if (empty($_GET["id"])) {
            $_SESSION["error"] = "ID de rol no proporcionado.";
            header("Location: ?controller=role&action=index");
            exit;
        }

        $roleId = intval($_GET["id"]);

        $daoRole         = new RoleDAO();
        $daoFunction     = new FunctionDAO();
        $daoRoleFunction = new RoleFunctionDAO();

        $role = $daoRole->getById($roleId);

        if (!$role) {
            $_SESSION["error"] = "El rol no existe.";
            header("Location: ?controller=role&action=index");
            exit;
        }

        $functions = $daoFunction->getAll();
        $assigned  = $daoRoleFunction->getFunctionsByRole($roleId);

        $title = "Funciones del Rol";

        ob_start();
        require __DIR__ . "/../../Views/roles/functions.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    /* ==========================================
       AGREGAR FUNCIÓN A UN ROL
    ========================================== */
    public function addFunction()
    {
        $this->allowOnlyAdmin();

        if (empty($_POST["role_id"]) || empty($_POST["function_id"])) {
            $_SESSION["error"] = "Datos incompletos.";
            header("Location: ?controller=role&action=index");
            exit;
        }

        $roleId     = intval($_POST["role_id"]);
        $functionId = intval($_POST["function_id"]);

        $dao = new RoleFunctionDAO();
        $dao->addFunction([
            "role_id"     => $roleId,
            "function_id" => $functionId
        ]);

        header("Location: ?controller=role&action=functions&id=" . $roleId);
        exit;
    }

    /* ==========================================
       QUITAR FUNCIÓN A UN ROL
    ========================================== */
    public function removeFunction()
    {
        $this->allowOnlyAdmin();

        if (empty($_GET["id"]) || empty($_GET["role_id"])) {
            $_SESSION["error"] = "Parámetros incompletos.";
            header("Location: ?controller=role&action=index");
            exit;
        }

        $id     = intval($_GET["id"]);
        $roleId = intval($_GET["role_id"]);

        $dao = new RoleFunctionDAO();
        $dao->removeFunction($id);

        header("Location: ?controller=role&action=functions&id=" . $roleId);
        exit;
    }
}
