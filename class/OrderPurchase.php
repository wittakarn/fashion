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
    
    public static function getByMemberId($conn, $memberId, $pos, $size) {
        $query = "SELECT * FROM order_purchase ";
        $where = "WHERE member_id = :member_id ";
        $order = "ORDER BY order_purchase_id DESC ";
        $limit = "LIMIT {$size} OFFSET {$pos} ";
        $stmt = $conn->prepare($query. $where . $order . $limit);
        $stmt->bindParam(":member_id", $memberId, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function countDuplicateOrder($conn, $customerName, $timestampMin, $timestampMax) {
        $query = "SELECT count(*) count FROM order_purchase o, customer c ";
        $where = "WHERE o.customer_id = c.customer_id "
                . "AND c.customer_name = :customer_name "
                . "AND o.order_purchase_adddate > :order_purchase_adddate_min "
                . "AND o.order_purchase_adddate < :order_purchase_adddate_max ";
        $stmt = $conn->prepare($query . $where);
        $stmt->bindParam(":customer_name", $customerName, PDO::PARAM_STR);
        $stmt->bindParam(":order_purchase_adddate_min", $timestampMin, PDO::PARAM_STR);
        $stmt->bindParam(":order_purchase_adddate_max", $timestampMax, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}

?>