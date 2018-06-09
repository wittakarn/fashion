<?php

class ProductDetail {

    public static function getProduct($conn, $productId) {
        $query = "SELECT * FROM product_detail WHERE product_id = :product_id ";
        $limit = "LIMIT 1 ";
        $stmt = $conn->prepare($query . $limit);
        $stmt->bindParam(":product_id", $productId, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllProductAmount($product) {
        $totalAmount = 0;
        $product_detail_2_color = $product["product_detail_2_color"];
        $product_detail_2_stock = $product["product_detail_2_stock"];
        $product_detail_3_color = $product["product_detail_3_color"];
        $product_detail_3_stock = $product["product_detail_3_stock"];
        $product_detail_4_color = $product["product_detail_4_color"];
        $product_detail_4_stock = $product["product_detail_4_stock"];
        $product_detail_5_color = $product["product_detail_5_color"];
        $product_detail_5_stock = $product["product_detail_5_stock"];
        $product_detail_6_color = $product["product_detail_6_color"];
        $product_detail_6_stock = $product["product_detail_6_stock"];
        $product_detail_7_color = $product["product_detail_7_color"];
        $product_detail_7_stock = $product["product_detail_7_stock"];
        $product_detail_8_color = $product["product_detail_8_color"];
        $product_detail_8_stock = $product["product_detail_8_stock"];
        if ($product_detail_2_color != NULL) {
            $totalAmount = $totalAmount + $product_detail_2_stock;
        }
        if ($product_detail_3_color != NULL) {
            $totalAmount = $totalAmount + $product_detail_3_stock;
        }
        if ($product_detail_4_color != NULL) {
            $totalAmount = $totalAmount + $product_detail_4_stock;
        }
        if ($product_detail_5_color != NULL) {
            $totalAmount = $totalAmount + $product_detail_5_stock;
        }
        if ($product_detail_6_color != NULL) {
            $totalAmount = $totalAmount + $product_detail_6_stock;
        }
        if ($product_detail_7_color != NULL) {
            $totalAmount = $totalAmount + $product_detail_7_stock;
        }
        if ($product_detail_8_color != NULL) {
            $totalAmount = $totalAmount + $product_detail_8_stock;
        }
        return $totalAmount;
    }

    public static function getProductAmount($product, $productSub) {
        $productAmount;
        if ($productSub == 1) {
            $productAmount = $product["product_detail_1_stock"];
        } else if ($productSub == 2) {
            $productAmount = $product["product_detail_2_stock"];
        } else if ($productSub == 3) {
            $productAmount = $product["product_detail_3_stock"];
        } else if ($productSub == 4) {
            $productAmount = $product["product_detail_4_stock"];
        } else if ($productSub == 5) {
            $productAmount = $product["product_detail_5_stock"];
        } else if ($productSub == 6) {
            $productAmount = $product["product_detail_6_stock"];
        } else if ($productSub == 7) {
            $productAmount = $product["product_detail_7_stock"];
        } else if ($productSub == 8) {
            $productAmount = $product["product_detail_8_stock"];
        }
        return $productAmount;
    }

}

?>