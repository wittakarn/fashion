<?php

class OrderPurchaseDetail {

    public static function getByOrderPurchaseId($conn, $orderPurchaseId) {
        $query = "SELECT * FROM order_purchase_detail WHERE order_purchase_id = :order_purchase_id ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":order_purchase_id", $orderPurchaseId, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>