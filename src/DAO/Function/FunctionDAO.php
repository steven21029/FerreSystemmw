<?php

namespace DAO\Function;

use Config\Database;
use PDO;

class FunctionDAO
{
    public function getAll()
    {
        $db = Database::connect();

        $sql = "SELECT * FROM functions ORDER BY id ASC";

        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $db = Database::connect();

        $sql = "SELECT * FROM functions WHERE id = :id LIMIT 1";

        $stm = $db->prepare($sql);
        $stm->execute([":id" => $id]);

        return $stm->fetch(PDO::FETCH_ASSOC);
    }
}
