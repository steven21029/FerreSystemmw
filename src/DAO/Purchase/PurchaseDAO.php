<?php

namespace DAO\Purchase;

use Config\Database;
use PDO;

class PurchaseDAO {

    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getAll() {
        $sql = "SELECT 
                    p.*, 
                    u.name AS user_name
                FROM purchases p
                JOIN users u ON u.id = p.user_id
                ORDER BY p.id DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($userId, $total) {
        $sql = "INSERT INTO purchases (user_id, total) 
                VALUES (:user_id, :total)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ":user_id" => $userId,
            ":total"   => $total
        ]);

        return $this->db->lastInsertId();
    }
}
