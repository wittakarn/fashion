<?php

class ProductOpt {

    public static function getProductOptByProductId($conn, $productId) {
        $query = "SELECT * FROM product_opt WHERE product_id = :product_id ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":product_id", $productId, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}

?>