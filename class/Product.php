<?php

class Category {

    public static function getProductByCate3Id($conn, $cate3Id) {
        $query = 'SELECT * FROM product WHERE cate3_id = :cate3_id ';
        $order = 'ORDER BY product_code DESC';
        $stmt = $conn->prepare($query . $order);
        $stmt->bindParam(":cate3_id", $cate3Id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>