<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once '../config.php';
require_once DOCUMENT_ROOT . '/connection.php';
require_once DOCUMENT_ROOT . '/class/Product.php';
require_once DOCUMENT_ROOT . '/class/ProductOpt.php';
require_once DOCUMENT_ROOT . '/class/ProductDetail.php';
require_once DOCUMENT_ROOT . '/class/Category.php';
require_once DOCUMENT_ROOT . '/class/Category.php';
require_once '../../function/function_php.php';

$response = null;
try {
    $productUids = $_REQUEST['productUids'];
    
    $result = array();
    $conn = DataBaseConnection::createConnect();
    
    foreach ($productUids as &$productUid) {
        $part = explode("#", $productUid);
        $productDetail = ProductDetail::getProduct($conn, $part[0]);
        $productDetailXStock = "product_detail_{$part[1]}_stock";
        $product['productUid'] = $productUid;
        $product['amount'] = $productDetail[$productDetailXStock];
        
        array_push($result, $product);
    }
    $response = $result;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

echo json_encode($response);
?>