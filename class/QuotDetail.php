<?php

class QuotDetail {

    public $requests;
    public $dbh;

    public function __construct($conn, $param) {
        $this->requests = $param;
        $this->dbh = $conn;
    }

    public function create($quotNo) {
        $params = $this->requests;
        $db = $this->dbh;
        $query = "INSERT INTO quot_detail(quot_no, product_uid, sequence, image_path, quantity, product_detail, price, total_price) VALUES (:quot_no, :product_uid, :sequence, :image_path, :quantity, :product_detail, :price, :total_price)";
        $stmt = $db->prepare($query);
        foreach ($params as $item) {
            $stmt->bindParam(":quot_no", $quotNo, PDO::PARAM_INT);
            $stmt->bindParam(":product_uid", $item['product_uid'], PDO::PARAM_STR);
            $stmt->bindParam(":sequence", $item['sequence'], PDO::PARAM_INT);
            $stmt->bindParam(":image_path", $item['image_path'], PDO::PARAM_STR);
            $stmt->bindParam(":quantity", $item['quantity'], PDO::PARAM_INT);
            $stmt->bindParam(":product_detail", $item['product_detail'], PDO::PARAM_STR);
            $stmt->bindValue(":price", $item['price'], PDO::PARAM_STR);
            $stmt->bindValue(":total_price", $item['total_price'], PDO::PARAM_STR);

            $stmt->execute();
        }
    }

    public function deleteByQuotNo() {
        $params = $this->requests;
        $db = $this->dbh;
        $query = "DELETE FROM quot_detail WHERE quot_no = :quot_no";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":quot_no", $params['quot_no'], PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function getQuotationDetailByQuotNo($conn, $quotNo) {
        $query = "SELECT * FROM quot_detail WHERE quot_no = :quot_no ";
        $order = "ORDER BY sequence ASC";
        $stmt = $conn->prepare($query . $order);
        $stmt->bindParam(":quot_no", $quotNo, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getQuotationDetailAndCapitalPriceByQuotNo($conn, $quotNo) {
        $query = "SELECT a.*, b.capital_price FROM quot_detail a, product b ";
        $query .= "WHERE a.product_id = b.product_id AND a.quot_no = :quot_no ";
        $order = "ORDER BY a.sequence ASC";

        //echo $query.$order;

        $stmt = $conn->prepare($query . $order);
        $stmt->bindParam(":quot_no", $quotNo, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>