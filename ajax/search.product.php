<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once '../config.php';
require_once DOCUMENT_ROOT . '/connection.php';
require_once DOCUMENT_ROOT . '/class/Product.php';
require_once DOCUMENT_ROOT . '/class/ProductOpt.php';
require_once DOCUMENT_ROOT . '/class/ProductDetail.php';
require_once DOCUMENT_ROOT . '/class/Category.php';

$response = null;
try {
    $cate3Opt = $_REQUEST['cate3Opt'];
    $result = array();
    $conn = DataBaseConnection::createConnect();
    $productResults = Product::getProductByCate3Id($conn, $_REQUEST['cate3Id'], $_REQUEST['pos'], $_REQUEST['size']);
    foreach ($productResults as &$productResult) {
        $productId = $productResult['product_id'];
        $productDetail = ProductDetail::getProduct($conn, $productId);

        if ($cate3Opt == "y") {
            if (ProductDetail::getAllProductAmount($productDetail) == 0) {
                continue;
            }

            $productOpt = ProductOpt::getProductOptByProductId($conn, $productId);

            if ($productOpt != NULL) {
                $options = array();
                for ($index = 2; $index < 9; $index++) {
                    $productOptDimension = "product_opt_{$index}_dimension";
                    $productOptCode = "product_opt_{$index}_code";
                    $productOptCostcn = "product_opt_{$index}_costcn";
                    if (ProductDetail::getProductAmount($productDetail, $index) != 0 && ($productOpt[$productOptCode] != NULL && $productOpt[$productOptCostcn] != NULL)) {
                        $option["option_index"] = $index;
                        $option["product_opt_dimension"] = $productOpt[$productOptDimension];
                        $option["product_opt_code"] = $productOpt[$productOptCode];
                        $option["product_opt_costcn"] = $productOpt[$productOptCostcn];
                        array_push($options, $option);
                    }
                }
                $productResult['product_opts'] = $options;
            }
            array_push($result, $productResult);
        } else {
            for ($index = 1; $index < 9; $index++) {
                $productDetailXStock = "product_detail_{$index}_stock";
                if ($productDetail[$productDetailXStock] != NULL && $productDetail[$productDetailXStock] > 0) {
                    $productResult['cate3_name'] = Category::getCate3ByCate3Id($conn, $productId);
                    $productResult['option_index'] = $index;
                    $productResult['product_opts'] = null;
                    array_push($result, $productResult);
                }
            }
        }
    }
    $response = $result;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

echo json_encode($response);
?>