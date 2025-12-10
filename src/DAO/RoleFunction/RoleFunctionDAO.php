<?php

namespace DAO\RoleFunction;

use Config\Database;
use PDO;

class RoleFunctionDAO {

    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getAll() {
        $sql = "SELECT rf.id, r.name AS role_name, f.name AS function_name
                FROM role_function rf
                INNER JOIN roles r ON rf.role_id = r.id
                INNER JOIN functions f ON rf.function_id = f.id";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFunctionsByRole($roleId) {
        $sql = "SELECT rf.id, f.name
                FROM role_function rf
                INNER JOIN functions f ON rf.function_id = f.id
                WHERE rf.role_id = :roleId";

        $stm = $this->db->prepare($sql);
        $stm->execute([":roleId" => $roleId]);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addFunction($data) {
        $sql = "INSERT INTO role_function (role_id, function_id)
                VALUES (:role_id, :function_id)";

        $stm = $this->db->prepare($sql);
        return $stm->execute([
            ":role_id"     => $data["role_id"],
            ":function_id" => $data["function_id"]
        ]);
    }

    public function removeFunction($id) {
        $sql = "DELETE FROM role_function WHERE id = :id";

        $stm = $this->db->prepare($sql);
        return $stm->execute([":id" => $id]);
    }
}
