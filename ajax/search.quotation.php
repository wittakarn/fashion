<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once '../config.php';
require_once DOCUMENT_ROOT . '/connection.php';
require_once DOCUMENT_ROOT . '/class/QuotMast.php';
require_once DOCUMENT_ROOT . '/class/QuotDetail.php';

$response = array();
try {
    if(!isset($_REQUEST['quot_no'])) return $response;
    $quotNo = $_REQUEST['quot_no'];
    $conn = DataBaseConnection::createConnect();
    $quotMast = QuotMast::get($conn, $quotNo);
    $quotDetail = QuotDetail::getQuotationDetailByQuotNo($conn, $quotNo);
    $response['quotMast'] = $quotMast;
    $response['quotDetail'] = $quotDetail;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

echo json_encode($response);
?>