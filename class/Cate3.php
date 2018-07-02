<?php

class Cate3 {

    public static function get($conn, $cate3Id) {
        $query = "SELECT * FROM cate3 WHERE cate3_id = :cate3_id ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":cate3_id", $cate3Id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}

?>