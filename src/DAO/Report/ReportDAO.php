<?php

namespace DAO\Report;

use Config\Database;
use PDO;

class ReportDAO {

    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getGeneralReport() {
        $sql = "
            SELECT 
                p.id,
                p.name AS producto,
                p.description,
                p.price AS precio,
                c.name AS categoria,

                IFNULL((SELECT SUM(quantity) 
                        FROM inventory 
                        WHERE product_id = p.id), 0) AS stock_total,

                IFNULL((SELECT SUM(quantity) 
                        FROM inventory 
                        WHERE product_id = p.id AND quantity > 0), 0) AS total_entradas,

                ABS(IFNULL((SELECT SUM(quantity) 
                        FROM inventory 
                        WHERE product_id = p.id AND quantity < 0), 0)) AS total_salidas,

                IFNULL((SELECT SUM(quantity) 
                        FROM sale_items 
                        WHERE product_id = p.id), 0) AS total_vendido

            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            ORDER BY p.id ASC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSalesReport() {
        $sql = "
            SELECT 
                s.id AS venta_id,
                s.created_at AS fecha,
                u.name AS usuario,
                s.total AS total_venta,
                COUNT(si.id) AS items,
                SUM(si.qty) AS cantidad_total
            FROM sales s
            LEFT JOIN users u ON u.id = s.user_id
            LEFT JOIN sale_items si ON si.sale_id = s.id
            GROUP BY s.id
            ORDER BY s.created_at DESC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInventoryReport() {
        $sql = "
            SELECT 
                p.id,
                p.name,
                p.price,
                c.name AS categoria,
                IFNULL(SUM(i.quantity), 0) AS stock
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN inventory i ON p.id = i.product_id
            GROUP_BY p.id
            ORDER BY p.name ASC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getKardexReport() {
        $sql = "
            SELECT 
                i.id,
                p.name AS producto,
                i.quantity,
                i.reference,
                i.created_at
            FROM inventory i
            INNER JOIN products p ON p.id = i.product_id
            ORDER BY p.name ASC, i.created_at DESC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductsReport() {
        $sql = "
            SELECT 
                p.id,
                p.name,
                p.description,
                p.price,
                c.name AS categoria
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            ORDER BY p.id ASC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsersReport() {
        $sql = "
            SELECT 
                u.id,
                u.name,
                u.email,
                u.created_at
            FROM users u
            ORDER BY u.id ASC
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
