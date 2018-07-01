<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once '../config.php';
require_once DOCUMENT_ROOT . '/connection.php';
require_once DOCUMENT_ROOT . '/class/OrderPurchase.php';
require_once DOCUMENT_ROOT . '/class/Member.php';
require_once DOCUMENT_ROOT . '/class/Customer.php';
require_once DOCUMENT_ROOT . '/class/OrderPurchaseDetail.php';

try {
    $result = array();
    $conn = DataBaseConnection::createConnect();
    $orders = OrderPurchase::getAll($conn, $_REQUEST['pos'], $_REQUEST['size']);
    foreach ($orders as &$order) {
        $order['member'] = Member::get($conn, $order['member_id']);
        $order['customer'] = Customer::get($conn, $order['customer_id']);
        $order['purchase_detail'] = OrderPurchaseDetail::getByOrderPurchaseId($conn, $order['order_purchase_id']);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

echo json_encode($orders);
?>