<?php

namespace DAO\PurchaseItem;

use Config\Database;
use PDO;

class PurchaseItemDAO {

    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function saveItem($purchaseId, $productId, $qty, $price) {
        $sql = "INSERT INTO purchase_items 
                (purchase_id, product_id, qty, price)
                VALUES (:purchase_id, :product_id, :qty, :price)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ":purchase_id" => $purchaseId,
            ":product_id"  => $productId,
            ":qty"         => $qty,
            ":price"       => $price
        ]);
    }
}
