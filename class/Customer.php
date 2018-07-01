<?php

class Customer {

    public static function get($conn, $customerId) {
        $query = "SELECT * FROM customer WHERE customer_id = :customer_id ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":customer_id", $customerId, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}

?>