<?php

class QuotMast {

    public $requests;
    public $dbh;

    public function __construct($conn, $param) {
        $this->requests = $param;
        $this->dbh = $conn;
    }

    public function create() {
        $params = $this->requests;
        $db = $this->dbh;
        $query = "INSERT INTO quot_mast(quot_no, member_id, user, date, summary_price, create_datetime) VALUES (:quot_no, :member_id, :name, NOW(), :summary_price, NOW())";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":quot_no", $params['quot_no'], PDO::PARAM_STR);
        $stmt->bindParam(":member_id", $params['member_id'], PDO::PARAM_INT);
        $stmt->bindParam(":name", $params['name'], PDO::PARAM_STR);
        $stmt->bindValue(":summary_price", str_replace(",", "", $params['summary_price']), PDO::PARAM_STR);

        $stmt->execute();
    }

    public function update($addition) {
        $params = $this->requests;
        $db = $this->dbh;
        $query = "UPDATE quot_mast SET total_price=:total_price,vat_price=:vat_price,net_price=:net_price,update_user_id=:update_user_id,update_datetime=NOW(),update_count=update_count+1 WHERE quot_no=:quot_no";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":quot_no", $addition['quot_no'], PDO::PARAM_STR);
        $stmt->bindValue(":total_price", str_replace(",", "", $params['total_price']), PDO::PARAM_STR);
        $stmt->bindValue(":vat_price", str_replace(",", "", $params['vat_price']), PDO::PARAM_STR);
        $stmt->bindValue(":net_price", str_replace(",", "", $params['net_price']), PDO::PARAM_STR);
        $stmt->bindParam(":update_user_id", $addition['user_id'], PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function get($conn, $quotNo) {
        $query = "SELECT * FROM quot_mast WHERE quot_no = :quot_no ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":quot_no", $quotNo, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getOldQuotations($conn, $customerId) {
        $query = "SELECT quot_no, date, net_price FROM quot_mast WHERE customer_id = :customer_id ";
        $order = "ORDER BY year DESC, sequence DESC ";
        $stmt = $conn->prepare($query . $order);
        $stmt->bindParam(":customer_id", $customerId, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getOldprices($conn, $customerId, $productId) {
        $query = "SELECT a.date, b.price FROM quot_mast a, quot_detail b WHERE a.quot_no = b.quot_no AND a.customer_id = :customer_id AND b.product_id = :product_id ";
        $order = "ORDER BY a.year DESC, a.date DESC, a.sequence DESC ";
        $limit = "LIMIT 10";
        $stmt = $conn->prepare($query . $order . $limit);
        $stmt->bindParam(":customer_id", $customerId, PDO::PARAM_INT);
        $stmt->bindParam(":product_id", $productId, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>