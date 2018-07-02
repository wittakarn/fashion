<?php

class Product {
    
    public static function get($conn, $productId) {
        $query = "SELECT * FROM product WHERE product_id = :product_id ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":product_id", $productId, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getProductByCate3Id($conn, $cate3Id, $pos, $size) {
        $query = "SELECT * FROM product WHERE cate3_id = :cate3_id ";
        $order = "ORDER BY product_code DESC ";
        $limit = "LIMIT {$size} OFFSET {$pos} ";
        $stmt = $conn->prepare($query . $order . $limit);
        $stmt->bindParam(":cate3_id", $cate3Id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>