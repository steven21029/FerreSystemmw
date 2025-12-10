<?php

namespace Controllers\Home;

class HomeController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $title = "Inicio";

         $cards = [
            ["nombre" => "Rony Moncada", "img" => "RonyMoncada.jpeg"],
            ["nombre" => "Arony Castillo", "img" => "AronyCastillo.jpeg"],
            ["nombre" => "Gladys Salmeron", "img" => "GladysSalmeron.jpeg"],
            ["nombre" => "Steven Rivera", "img" => "StevenRivera.jpeg"],
            ["nombre" => "Integrante 5", "img" => "persona5.jpg"],
            ["nombre" => "Integrante 6", "img" => "persona6.jpg"],
        ];

        ob_start();
        require __DIR__ . "/../../Views/home/index.php";
        $content = ob_get_clean();

        require __DIR__ . "/../../Views/layout.php";
    }
}
