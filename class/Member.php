<?php

class Member {

    public static function get($conn, $memberId) {
        $query = "SELECT * FROM member WHERE member_id = :member_id ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":member_id", $memberId, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}

?>