<?php

namespace DAO\Role;

use Config\Database;
use PDO;

class RoleDAO {

    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getAll() {
        $sql = "SELECT * FROM roles ORDER BY id ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM roles WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $stm->execute([":id" => $id]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name) {
        $sql = "INSERT INTO roles (name) VALUES (:name)";
        $stm = $this->db->prepare($sql);
        return $stm->execute([":name" => $name]);
    }

    public function update($id, $name) {
        $sql = "UPDATE roles SET name = :name WHERE id = :id";
        $stm = $this->db->prepare($sql);
        return $stm->execute([":name" => $name, ":id" => $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM roles WHERE id = :id";
        $stm = $this->db->prepare($sql);
        return $stm->execute([":id" => $id]);
    }
}
