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
    $priceType = $_REQUEST['priceType'];
    $cate3Name = $_REQUEST['cate3Name'];
    $cate3Opt = $_REQUEST['cate3Opt'];
    $result = array();
    $conn = DataBaseConnection::createConnect();
    $productResults = Product::getProductByCate3Id($conn, $_REQUEST['cate3Id'], $_REQUEST['pos'], $_REQUEST['size']);
    $needDoublePrice = $priceType != "C" && ($cate3Name == "peach" || $cate3Name == "bettyboop" || $cate3Name == "benbobear");
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
                        $option["product_uid"] = "{$productDetail['product_detail_id']}#{$index}";
                        $option["product_opt_dimension"] = $productOpt[$productOptDimension];
                        $option["product_opt_code"] = $productOpt[$productOptCode];
                        $option["product_opt_costcn"] = $productOpt[$productOptCostcn];
                        $option["price"] = get_price_product_cal($option["product_opt_costcn"], $productResult["cate2_id"], $cate3Name, $priceType) * ($needDoublePrice ? 2 : 1);
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
                    $productResult["product_uid"] = "{$productDetail['product_detail_id']}#{$index}";
                    $productResult['cate3_name'] = Category::getCate3ByCate3Id($conn, $productId);
                    $productResult['option_index'] = $index;
                    $productResult['product_opts'] = null;
                    $productResult['amount'] = $productDetail[$productDetailXStock];
                    $productResult["price"] = get_price_product_cal($productResult["product_cost_cn"], $productResult["cate2_id"], $cate3Name, $priceType);
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