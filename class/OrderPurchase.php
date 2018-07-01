<?php

class OrderPurchase {

    public static function getAll($conn, $pos, $size) {
        $query = "SELECT * FROM order_purchase ";
        $order = "ORDER BY order_purchase_id DESC ";
        $limit = "LIMIT {$size} OFFSET {$pos} ";
        $stmt = $conn->prepare($query . $order . $limit);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>