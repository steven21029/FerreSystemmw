<?php

namespace DAO\Product;

use Config\Database;
use PDO;

class ProductDAO 
{
    public function getAll() {
        $db = Database::connect();
        $sql = "SELECT * FROM products ORDER BY id DESC";
        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $db = Database::connect();
        $sql = "SELECT * FROM products WHERE id = :id LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $db = Database::connect();

        $sql = "INSERT INTO products 
                (name, description, category_id, price, stock, image_url)
                VALUES (:name, :description, :category_id, :price, :stock, :image_url)";

        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ":name"        => $data["name"],
            ":description" => $data["description"] ?? "",
            ":category_id" => $data["category_id"] ?? null,
            ":price"       => $data["price"],
            ":stock"       => $data["stock"] ?? 0,
            ":image_url"   => $data["image_url"] ?? ""
        ]);
    }

    public function update($data) {
        $db = Database::connect();

        $sql = "UPDATE products 
                SET name = :name,
                    description = :description,
                    category_id = :category_id,
                    price = :price,
                    stock = :stock,
                    image_url = :image_url
                WHERE id = :id";

        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ":name"        => $data["name"],
            ":description" => $data["description"],
            ":category_id" => $data["category_id"],
            ":price"       => $data["price"],
            ":stock"       => $data["stock"],
            ":image_url"   => $data["image_url"],
            ":id"          => $data["id"]
        ]);
    }

    public function delete($id) {
        $db = Database::connect();
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }

    public function updateStock($id, $newStock) {
        $db = Database::connect();
        $sql = "UPDATE products SET stock = :stock WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ":stock" => $newStock,
            ":id"    => $id
        ]);
    }
}

