<?php

namespace DAO\UserRole;

use Config\Database;
use PDO;

class UserRoleDAO
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAll()
    {
        $sql = "
            SELECT 
                ur.id, 
                u.name AS user_name, 
                r.name AS role_name,
                ur.active
            FROM user_role ur
            INNER JOIN users u ON ur.user_id = u.id
            INNER JOIN roles r ON ur.role_id = r.id
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRolesByUser($userId)
    {
        $sql = "
            SELECT 
                ur.id, 
                r.name AS role_name
            FROM user_role ur
            INNER JOIN roles r ON ur.role_id = r.id
            WHERE ur.user_id = :userId
        ";

        $stm = $this->db->prepare($sql);
        $stm->execute([":userId" => $userId]);

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoleByUserId($userId)
    {
        $sql = "
            SELECT 
                r.name AS role_name
            FROM user_role ur
            INNER JOIN roles r ON ur.role_id = r.id
            WHERE ur.user_id = :user_id
            LIMIT 1
        ";

        $stm = $this->db->prepare($sql);
        $stm->execute([":user_id" => $userId]);

        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function addRole($data)
    {
        $sql = "
            INSERT INTO user_role (user_id, role_id)
            VALUES (:user_id, :role_id)
        ";

        $stm = $this->db->prepare($sql);

        return $stm->execute([
            ":user_id" => $data["user_id"],
            ":role_id" => $data["role_id"]
        ]);
    }

    public function removeRole($id)
    {
        $sql = "DELETE FROM user_role WHERE id = :id";

        $stm = $this->db->prepare($sql);

        return $stm->execute([":id" => $id]);
    }
}
