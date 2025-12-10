<?php

namespace DAO\SaleItem;

use Config\Database;
use PDO;

class SaleItemDAO
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Guardar un item de venta
     */
    public function saveItem($saleId, $productId, $qty, $price)
    {
        $sql = "INSERT INTO sale_items (sale_id, product_id, quantity, price)
                VALUES (:sale_id, :product_id, :quantity, :price)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ":sale_id"    => $saleId,
            ":product_id" => $productId,
            ":quantity"   => $qty,
            ":price"      => $price
        ]);
    }

    /**
     * Obtener todos los items de una venta
     */
    public function getBySaleId($saleId)
    {
        $sql = "SELECT si.*, p.name AS product_name
                FROM sale_items si
                JOIN products p ON p.id = si.product_id
                WHERE si.sale_id = :sale_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([":sale_id" => $saleId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
