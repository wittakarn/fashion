<?php

class Category {

    public static function getCate3ByCate1Id($conn, $cate1Id) {
        $query = "SELECT * FROM cate3 WHERE cate1_id = :cate1_id AND cate3_member_show = 'y' ";
        $order = "ORDER BY cate3_pos";
        $stmt = $conn->prepare($query . $order);
        $stmt->bindParam(":cate1_id", $cate1Id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>