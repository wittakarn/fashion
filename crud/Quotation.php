<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once("../config.php");
require_once DOCUMENT_ROOT . '/connection.php';
require_once DOCUMENT_ROOT . '/class/QuotNo.php';
require_once DOCUMENT_ROOT . '/class/QuotMast.php';
require_once DOCUMENT_ROOT . '/class/QuotDetail.php';

//array(4) { ["admin_username"]=> string(8) "expert11" ["admin_name"]=> string(8) "expert11" ["admin_level"]=> string(10) "superadmin" ["admin_login"]=> bool(true) }
//array(5) { ["member_id"]=> string(3) "294" ["member_name"]=> string(8) "expert12" ["member_fullname"]=> string(1) "a" ["member_class"]=> string(1) "B" ["member_login"]=> bool(true) }
class Quotation {

    public static function create($summaryPrice, $quotDetailParam) {
        $memberId = null;
        $userName = null;
        if (isset($_SESSION['member_name'])) {
            $userName = $_SESSION['member_name'];
        }
        if (isset($_SESSION['member_id'])) {
            $memberId = $_SESSION['member_id'];
        }

        $conn = DataBaseConnection::createConnect();
        $quotNo = "";
        try {
            $conn->beginTransaction();

            $quot = QuotNo::getMaxSequence($conn);
            $quotNo = $quot['sequence'];
            $quotMastParam['quot_no'] = $quotNo;
            $quotMastParam['member_id'] = $memberId;
            $quotMastParam['name'] = $userName;
            $quotMastParam['summary_price'] = $summaryPrice;

            $quotMast = new QuotMast($conn, $quotMastParam);
            $quotMast->create();

            $quotDetail = new QuotDetail($conn, $quotDetailParam);
            $quotDetail->create($quotNo);

            QuotNo::updateSequence($conn);

            $conn->commit();
        } catch (PDOException $e) {
            $conn->rollBack();
            echo "Failed: " . $e->getMessage();
        }
        $conn = null;
        return $quotNo;
    }

}

?>