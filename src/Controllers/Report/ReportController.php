<?php

namespace Controllers\Report;

use DAO\Report\ReportDAO;

class ReportController
{

    private function allowOnlyAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Validar login
        if (empty($_SESSION["user"])) {
            $_SESSION["error"] = "Debe iniciar sesión.";
            header("Location: ?controller=auth&action=login");
            exit;
        }

        // Validar rol
        if (($_SESSION["user"]["role"] ?? "") !== "admin") {
            $_SESSION["error"] = "Acceso denegado.";
            header("Location: ?controller=home&action=index");
            exit;
        }
    }

    public function index()
    {
        $this->allowOnlyAdmin();

        $title = "Reportes del Sistema";

        ob_start();
        require __DIR__ . "/../../Views/reports/index.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    public function general()
    {
        $this->allowOnlyAdmin();

        $dao = new ReportDAO();
        $data = $dao->getGeneralReport();

        $title = "Reporte General del Sistema";

        ob_start();
        require __DIR__ . "/../../Views/reports/general.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    public function ventas()
    {
        $this->allowOnlyAdmin();

        $dao = new ReportDAO();
        $ventas = $dao->getSalesReport();

        $title = "Reporte de Ventas";

        ob_start();
        require __DIR__ . "/../../Views/reports/ventas.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    public function inventario()
    {
        $this->allowOnlyAdmin();

        $dao = new ReportDAO();
        $inventario = $dao->getInventoryReport();

        $title = "Reporte de Inventario";

        ob_start();
        require __DIR__ . "/../../Views/reports/inventory.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    public function kardex()
    {
        $this->allowOnlyAdmin();

        $dao = new ReportDAO();
        $kardex = $dao->getKardexReport();

        $title = "Kardex de Movimientos";

        ob_start();
        require __DIR__ . "/../../Views/reports/kardex.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    public function productos()
    {
        $this->allowOnlyAdmin();

        $dao = new ReportDAO();
        $productos = $dao->getProductsReport();

        $title = "Reporte de Productos";

        ob_start();
        require __DIR__ . "/../../Views/reports/products.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }

    public function usuarios()
    {
        $this->allowOnlyAdmin();

        $dao = new ReportDAO();
        $usuarios = $dao->getUsersReport();

        $title = "Reporte de Usuarios";

        ob_start();
        require __DIR__ . "/../../Views/reports/users.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }
}
