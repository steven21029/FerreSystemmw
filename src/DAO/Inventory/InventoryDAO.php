<?php

namespace DAO\Inventory;

use Config\Database;
use PDO;

class InventoryDAO
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Obtener todos los movimientos de inventario
     */
    public function getAll()
    {
        $sql = "
            SELECT 
                i.id,
                i.product_id,
                i.quantity,
                i.movement_type,
                i.reference,
                i.created_at,
                p.name AS product_name
            FROM inventory i
            INNER JOIN products p ON p.id = i.product_id
            ORDER BY i.id DESC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener un movimiento por ID
     */
    public function getById($id)
    {
        $sql = "
            SELECT 
                i.id,
                i.product_id,
                i.quantity,
                i.movement_type,
                i.reference,
                i.created_at,
                p.name AS product_name
            FROM inventory i
            INNER JOIN products p ON p.id = i.product_id
            WHERE i.id = :id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id" => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Insertar movimiento de inventario
     */
    public function insert(array $data)
    {
        $quantity = intval($data["quantity"]);
        $movementType = $quantity >= 0 ? "ENTRADA" : "SALIDA";

        $sql = "
            INSERT INTO inventory (product_id, quantity, movement_type, reference)
            VALUES (:product_id, :quantity, :movement_type, :reference)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ":product_id"    => $data["product_id"],
            ":quantity"      => $quantity,
            ":movement_type" => $movementType,
            ":reference"     => $data["reference"] ?? ""
        ]);
    }

    /**
     * Agregar movimiento desde compras, ventas o kardex
     */
    public function addMovement($productId, $quantity, $type, $referenceId)
    {
        $sql = "
            INSERT INTO inventory (product_id, quantity, movement_type, reference)
            VALUES (:product_id, :quantity, :movement_type, :reference)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ":product_id"    => $productId,
            ":quantity"      => $quantity,
            ":movement_type" => strtoupper($type),
            ":reference"     => $referenceId
        ]);
    }

    /**
     * Actualizar cantidad (solo casos especiales)
     */
    public function updateQuantity($id, $quantity)
    {
        $sql = "
            UPDATE inventory
            SET quantity = :quantity
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ":quantity" => $quantity,
            ":id"       => $id
        ]);
    }
}
