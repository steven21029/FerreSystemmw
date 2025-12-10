<?php

namespace DAO\Kardex;

use Config\Database;
use PDO;

class KardexDAO
{
    private $db;

    public function __construct()
    {
        // ✔ Igual que en UserDAO: se guarda la conexión en una propiedad
        $this->db = Database::connect();
    }

    public function registrarMovimiento(
        $productId,
        $tipo,
        $cantidad,
        $stockAnterior,
        $stockNuevo,
        $descripcion,
        $usuarioId
    ) {
        // ✔ QUERY limpia y ordenada
        // ✔ NO se usa ":campo" dentro de $data, sino variables normales → estándar PSR
        $sql = "INSERT INTO kardex 
                (product_id, tipo, cantidad, stock_anterior, stock_nuevo, descripcion, user_id)
                VALUES 
                (:product_id, :tipo, :cantidad, :stock_anterior, :stock_nuevo, :descripcion, :user_id)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ":product_id"     => $productId,
            ":tipo"           => strtoupper($tipo), // ✔ Convertimos a mayúscula por estándar
            ":cantidad"       => intval($cantidad), // ✔ Aseguramos formato entero
            ":stock_anterior" => intval($stockAnterior),
            ":stock_nuevo"    => intval($stockNuevo),
            ":descripcion"    => $descripcion,
            ":user_id"        => $usuarioId
        ]);
    }

    public function getAll()
    {
        // ✔ SELECT profesional con alias
        // ✔ Ordenado DESC como corresponde en registros históricos
        $sql = "SELECT 
                    k.*, 
                    p.name AS product_name, 
                    u.name AS user_name
                FROM kardex k
                JOIN products p ON p.id = k.product_id
                JOIN users u ON u.id = k.user_id
                ORDER BY k.id DESC";

        // ✔ query() es correcto porque NO hay parámetros
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
