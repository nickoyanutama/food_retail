<?php

namespace FoodRetail\Repository;

use FoodRetail\Entity\Product;
use PDO;

class ProductRepository
{
    private PDO $connection;
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function All()
    {
        $sql = "SELECT id, qrcode, name, price, discount, is_expired, expired_at, created_at, updated_at FROM products WHERE deleted_at IS NULL";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $result = array();
        foreach ($statement as $row) {
            array_push($result, array(
                "id" => $row['id'],
                "qrcode" => $row['qrcode'],
                "name" => $row['name'],
                "price" => $row['price'],
                "discount" => $row['discount'],
                "is_expired" => $row['is_expired'],
                "expired_at" => $row['expired_at'],
                "created_at" => $row['created_at'],
                "updated_at" => $row['updated_at'],
            ));
        }
        return $result;
    }
    public function Pagination($firstData, $maxDataSinglePage, $totalPage)
    {
        $sql = "SELECT id, qrcode, name, price, discount, is_expired, expired_at, created_at, updated_at FROM products WHERE deleted_at IS NULL LIMIT $firstData, $maxDataSinglePage";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $result = [];
        if ($statement->rowCount()) {

            foreach ($statement as $row) {
                $firstData++;
                $result[$firstData] = [
                    "id" => $row['id'],
                    "qrcode" => $row['qrcode'],
                    "name" => $row['name'],
                    "price" => $row['price'],
                    "discount" => $row['discount'],
                    "is_expired" => $row['is_expired'],
                    "expired_at" => $row['expired_at'],
                    "created_at" => $row['created_at'],
                    "updated_at" => $row['updated_at'],
                ];
            }
            return json_encode(array('total_page' => $totalPage, 'data' => $result));
        } else {
            return json_encode(array('status' => 404, 'response' => 'Product Not Found'));
        }
    }

    public function findById($id)
    {
        $sql = "SELECT id, qrcode, name, price, discount, is_expired, expired_at, created_at, updated_at, deleted_at FROM products WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$id]);
        try {
            $result = [];
            if ($row = $statement->fetch()) {
                $result[0] = [
                    "id" => $row['id'],
                    "qrcode" => $row['qrcode'],
                    "name" => $row['name'],
                    "price" => $row['price'],
                    "discount" => $row['discount'],
                    "is_expired" => $row['is_expired'],
                    "expired_at" => $row['expired_at'],
                    "created_at" => $row['created_at'],
                    "updated_at" => $row['updated_at'],
                    "deleted_at" => $row['deleted_at'],
                ];
                return json_encode(array('data' => $result));
            } else {
                return json_encode(array('status' => 404, 'response' => 'Product Not Found'));
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function findByQr($qrcode)
    {
        $sql = "SELECT id, qrcode, name, price, discount, is_expired, expired_at, created_at, updated_at, deleted_at FROM products WHERE qrcode = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$qrcode]);
        try {
            $result = [];
            if ($row = $statement->fetch()) {
                $result[0] = [
                    "id" => $row['id'],
                    "qrcode" => $row['qrcode'],
                    "name" => $row['name'],
                    "price" => $row['price'],
                    "discount" => $row['discount'],
                    "is_expired" => $row['is_expired'],
                    "expired_at" => $row['expired_at'],
                    "created_at" => $row['created_at'],
                    "updated_at" => $row['updated_at'],
                    "deleted_at" => $row['deleted_at'],
                ];
                return json_encode(array('data' => $result));
            } else {
                return json_encode(array('status' => 404, 'response' => 'Product Not Found'));
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function save(Product $product)
    {
        $sql = "INSERT INTO products (qrcode, name, price, discount, is_expired, expired_at) VALUES (?,?,?,?,?,?)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            $product->getQrcode(),
            $product->getName(),
            $product->getPrice(),
            $product->getDiscount(),
            $product->getIsExpired(),
            $product->getExpiredAt(),
        ]);
    }

    public function update(Product $product)
    {
        $sql = "UPDATE products SET qrcode = ?, name = ?, price = ?, discount = ?, is_expired = ?, expired_at = ? WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            $product->getQrcode(),
            $product->getName(),
            $product->getPrice(),
            $product->getDiscount(),
            $product->getIsExpired(),
            $product->getExpiredAt(),
            $product->getId(),
        ]);
    }

    public function updateQr(Product $product)
    {
        $sql = "UPDATE products SET qrcode = ? WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            $product->getQrcode(),
            $product->getId()
        ]);
    }

    public function remove(Product $product)
    {
        $sql = "SELECT * FROM product WHERE qrcode = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$product->getQrcode()]);
        if ($statement->fetch()) {
            $sql = "DELETE FROM products WHERE qrcode = ?";
            $statement = $this->connection->prepare($sql);
            $statement->execute([$product->getQrcode()]);

            return true;
        }
        return false;
    }

    public function removeAll()
    {
        $this->connection->exec("TRUNCATE TABLE products");
    }

    public function softDelete(Product $product)
    {
        $sql = "UPDATE products SET deleted_at = ? WHERE qrcode = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            $product->getDeletedAt(),
            $product->getQrcode()
        ]);
    }
}
