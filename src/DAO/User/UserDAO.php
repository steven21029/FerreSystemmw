<?php

namespace DAO\User;

use Config\Database;
use PDO;

class UserDAO
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
                u.id,
                u.name,
                u.email,
                u.active
            FROM users u
            ORDER BY u.id ASC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";

        $stm = $this->db->prepare($sql);
        $stm->execute([":id" => $id]);

        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email)
    {
        $sql = "
            SELECT 
                u.*,
                r.name AS role
            FROM users u
            LEFT JOIN user_role ur ON ur.user_id = u.id
            LEFT JOIN roles r ON r.id = ur.role_id
            WHERE u.email = :email
            LIMIT 1
        ";

        $stm = $this->db->prepare($sql);
        $stm->execute([":email" => $email]);

        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "
            INSERT INTO users (name, email, password_hash)
            VALUES (:name, :email, MD5(:password))
        ";

        $stm = $this->db->prepare($sql);

        return $stm->execute([
            ":name"     => $data["name"],
            ":email"    => $data["email"],
            ":password" => $data["password"]
        ]);
    }

    public function update($data)
    {
        $sql = "
            UPDATE users
            SET name = :name,
                email = :email
            WHERE id = :id
        ";

        $stm = $this->db->prepare($sql);

        return $stm->execute([
            ":name"  => $data["name"],
            ":email" => $data["email"],
            ":id"    => $data["id"]
        ]);
    }

    public function activate($id)
    {
        $sql = "UPDATE users SET active = 1 WHERE id = :id";

        $stm = $this->db->prepare($sql);

        return $stm->execute([":id" => $id]);
    }

    public function deactivate($id)
    {
        $sql = "UPDATE users SET active = 0 WHERE id = :id";

        $stm = $this->db->prepare($sql);

        return $stm->execute([":id" => $id]);
    }
}
