<?php

class QuotNo {

    public static function getMaxSequence($conn) {
        $query = "SELECT sequence FROM quot_no LIMIT 1";
        $stmt = $conn->prepare($query);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateSequence($conn) {
        $query = "UPDATE quot_no SET sequence=sequence+1";
        $stmt = $conn->prepare($query);

        $stmt->execute();
    }

}

?>