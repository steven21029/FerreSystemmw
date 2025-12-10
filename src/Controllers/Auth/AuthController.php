<?php

namespace Controllers\Auth;

use DAO\User\UserDAO;
use DAO\UserRole\UserRoleDAO;

class AuthController
{   
    public function login()
    {
        $title = "Iniciar sesión";

        ob_start();
        require __DIR__ . "/../../Views/auth/login.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    public function doLogin()
    {
        session_start();

        $email    = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";

        $dao  = new UserDAO();
        $user = $dao->getByEmail($email);

        // Usuario incorrecto o password no coincide
        if (!$user || $user["password_hash"] !== md5($password)) {
            $_SESSION["error"] = "Correo o contraseña incorrectos.";
            header("Location: ?controller=auth&action=login");
            exit;
        }

        // Usuario desactivado
        if ($user["active"] == 0) {
            $_SESSION["error"] = "Usuario desactivado.";
            header("Location: ?controller=auth&action=login");
            exit;
        }

        // Obtener el rol del usuario
        $roleDAO  = new UserRoleDAO();
        $roleData = $roleDAO->getRoleByUserId($user["id"]);
        $rol      = strtolower($roleData["role_name"] ?? "cliente");

        // Guardar sesión
        $_SESSION["user"] = [
            "id"     => $user["id"],
            "name"   => $user["name"],
            "email"  => $user["email"],
            "active" => $user["active"],
            "role"   => $rol
        ];

        header("Location: ?controller=home&action=index");
        exit;
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: ?controller=auth&action=login");
        exit;
    }
}
