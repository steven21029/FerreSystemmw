<?php

namespace Controllers\User;

use DAO\User\UserDAO;
use DAO\Role\RoleDAO;
use DAO\UserRole\UserRoleDAO;

class UserController 
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
       LISTAR USUARIOS
    ========================================== */
    public function index() 
    {
        $this->allowOnlyAdmin();

        $dao = new UserDAO();
        $users = $dao->getAll();

        $title = "Usuarios del Sistema";

        ob_start();
        require __DIR__ . "/../../Views/users/index.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    /* ==========================================
       FORMULARIO PARA CREAR USUARIO
    ========================================== */
    public function create() 
    {
        $this->allowOnlyAdmin();

        $title = "Crear Usuario";

        ob_start();
        require __DIR__ . "/../../Views/users/create.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    /* ==========================================
       GUARDAR USUARIO
    ========================================== */
    public function store() 
    {
        $this->allowOnlyAdmin();

        if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"])) {
            $_SESSION["error"] = "Todos los campos son obligatorios.";
            header("Location: ?controller=user&action=create");
            exit;
        }

        $dao = new UserDAO();
        $dao->create($_POST);

        header("Location: ?controller=user&action=index");
        exit;
    }

    /* ==========================================
       FORMULARIO: Editar usuario
    ========================================== */
    public function edit() 
    {
        $this->allowOnlyAdmin();

        if (empty($_GET["id"])) {
            $_SESSION["error"] = "ID no proporcionado.";
            header("Location: ?controller=user&action=index");
            exit;
        }

        $dao = new UserDAO();
        $user = $dao->getById($_GET["id"]);

        if (!$user) {
            $_SESSION["error"] = "Usuario no encontrado.";
            header("Location: ?controller=user&action=index");
            exit;
        }

        $title = "Editar Usuario";

        ob_start();
        require __DIR__ . "/../../Views/users/edit.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    /* ==========================================
       ACTUALIZAR USUARIO
    ========================================== */
    public function update() 
    {
        $this->allowOnlyAdmin();

        if (empty($_POST["id"])) {
            $_SESSION["error"] = "ID no proporcionado.";
            header("Location: ?controller=user&action=index");
            exit;
        }

        $dao = new UserDAO();
        $dao->update($_POST);

        header("Location: ?controller=user&action=index");
        exit;
    }

    /* ==========================================
       ACTIVAR USUARIO
    ========================================== */
    public function activate() 
    {
        $this->allowOnlyAdmin();

        if (empty($_GET["id"])) {
            $_SESSION["error"] = "ID no proporcionado.";
            header("Location: ?controller=user&action=index");
            exit;
        }

        $dao = new UserDAO();
        $dao->activate($_GET["id"]);

        header("Location: ?controller=user&action=index");
        exit;
    }

    /* ==========================================
       DESACTIVAR USUARIO
    ========================================== */
    public function deactivate() 
    {
        $this->allowOnlyAdmin();

        if (empty($_GET["id"])) {
            $_SESSION["error"] = "ID no proporcionado.";
            header("Location: ?controller=user&action=index");
            exit;
        }

        $dao = new UserDAO();
        $dao->deactivate($_GET["id"]);

        header("Location: ?controller=user&action=index");
        exit;
    }

    /* ==========================================
       ROLES DEL USUARIO
    ========================================== */
    public function roles() 
    {
        $this->allowOnlyAdmin();

        if (empty($_GET["id"])) {
            $_SESSION["error"] = "ID no proporcionado.";
            header("Location: ?controller=user&action=index");
            exit;
        }

        $userId = intval($_GET["id"]);

        $daoUser     = new UserDAO();
        $daoRole     = new RoleDAO();
        $daoUserRole = new UserRoleDAO();

        $user = $daoUser->getById($userId);

        if (!$user) {
            $_SESSION["error"] = "Usuario no encontrado.";
            header("Location: ?controller=user&action=index");
            exit;
        }

        $roles    = $daoRole->getAll();
        $assigned = $daoUserRole->getRolesByUser($userId);

        $title = "Roles del Usuario";

        ob_start();
        require __DIR__ . "/../../Views/users/roles.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    /* ==========================================
       AGREGAR ROL A USUARIO
    ========================================== */
    public function addRole() 
    {
        $this->allowOnlyAdmin();

        if (empty($_POST["user_id"]) || empty($_POST["role_id"])) {
            $_SESSION["error"] = "Datos incompletos.";
            header("Location: ?controller=user&action=index");
            exit;
        }

        $dao = new UserRoleDAO();
        $dao->addRole($_POST);

        header("Location: ?controller=user&action=roles&id=" . intval($_POST["user_id"]));
        exit;
    }

    /* ==========================================
       QUITAR ROL A USUARIO
    ========================================== */
    public function removeRole() 
    {
        $this->allowOnlyAdmin();

        if (empty($_GET["id"]) || empty($_GET["user_id"])) {
            $_SESSION["error"] = "Parámetros incompletos.";
            header("Location: ?controller=user&action=index");
            exit;
        }

        $dao = new UserRoleDAO();
        $dao->removeRole(intval($_GET["id"]));

        header("Location: ?controller=user&action=roles&id=" . intval($_GET["user_id"]));
        exit;
    }
}
