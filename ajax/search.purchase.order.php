<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once '../config.php';
require_once DOCUMENT_ROOT . '/connection.php';
require_once DOCUMENT_ROOT . '/class/OrderPurchase.php';
require_once DOCUMENT_ROOT . '/class/Member.php';
require_once DOCUMENT_ROOT . '/class/Customer.php';
require_once DOCUMENT_ROOT . '/class/OrderPurchaseDetail.php';
require_once DOCUMENT_ROOT . '/class/Cate3.php';
require_once DOCUMENT_ROOT . '/class/Product.php';

try {
    //date_default_timezone_set("Asia/Bangkok");
    $result = array();
    $conn = DataBaseConnection::createConnect();
    $orders = $_REQUEST['memberId'] == null 
            ? OrderPurchase::getAll($conn, $_REQUEST['pos'], $_REQUEST['size']) 
            : OrderPurchase::getByMemberId($conn, $_REQUEST['memberId'], $_REQUEST['pos'], $_REQUEST['size']);
    foreach ($orders as &$order) {
        $purchaseDate = strtotime($order['order_purchase_adddate']);
//        $purchaseDate_1 = date('d/m/Y H:i:s', strtotime(' -1 days', $purchaseDate));
//        $purchaseDate_2 = date('d/m/Y H:i:s', strtotime(' -2 days', $purchaseDate));
//        $order['timestamp-1'] = date('YmdHi', strtotime(' -1 days', $purchaseDate));
//        $order['timestamp-2'] = date('YmdHi', strtotime(' -2 days', $purchaseDate));
        $order['dateTime'] = date('d/m/Y H:i:s', $purchaseDate);
        $order['member'] = Member::get($conn, $order['member_id']);
        $order['customer'] = Customer::get($conn, $order['customer_id']);
        $duplicate = OrderPurchase::countDuplicateOrder($conn, $order['customer']['customer_name'], date('YmdHi', strtotime(' -3 days', $purchaseDate)), $order['order_purchase_adddate']);
        $order['isDuplicate'] = $duplicate['count'] > 0;
        $purchaseDetails = OrderPurchaseDetail::getByOrderPurchaseId($conn, $order['order_purchase_id']);
        $images = array();
        foreach ($purchaseDetails as &$purchaseDetail) {
            $product = Product::get($conn, $purchaseDetail['product_id']);
            $cate3 = Cate3::get($conn, $product['cate3_id']);
            $imageDetails['imageSrc'] = "pic/product/{$cate3['cate3_name']}/{$product['product_code']}/{$product['product_name2']}^{$purchaseDetail['product_sub']}_main.jpg";
            $imageDetails['stock'] = $purchaseDetail['product_stock'];
            array_push($images, $imageDetails);
        }
        $order['images'] = $images;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

echo json_encode($orders);
?>