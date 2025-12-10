<?php

namespace DAO\Sale;

use Config\Database;
use PDO;

class SaleDAO
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAll()
    {
        $sql = "SELECT s.*, u.name AS user_name
                FROM sales s
                JOIN users u ON u.id = s.user_id
                ORDER BY s.id DESC";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($userId, $total)
    {
        $sql = "INSERT INTO sales (user_id, total)
                VALUES (:user_id, :total)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ":user_id" => $userId,
            ":total"   => $total
        ]);

        return $this->db->lastInsertId();
    }

    public function getById($id)
    {
        $sql = "SELECT s.*, u.name AS user_name
                FROM sales s
                JOIN users u ON u.id = s.user_id
                WHERE s.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id" => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        return $this->getById($id);
    }

    public function registerInventoryMove($productId, $quantity, $saleId)
    {
        // Se registra como SALIDA (negativo)
        $movement = -abs($quantity);

        $sql = "INSERT INTO inventory (product_id, quantity, movement_type, reference)
                VALUES (:product_id, :quantity, 'SALIDA', :reference)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ":product_id" => $productId,
            ":quantity"   => $movement,
            ":reference"  => "Venta #" . $saleId
        ]);
    }

    public function getSalesByUser($userId)
    {
        $sql = "SELECT s.*, u.name AS user_name
                FROM sales s
                JOIN users u ON u.id = s.user_id
                WHERE s.user_id = :user_id
                ORDER BY s.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([":user_id" => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
