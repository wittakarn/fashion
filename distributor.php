<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('config.php');
require_once('connection.php');
require_once(DOCUMENT_ROOT . '/class/Helper.php');
$conn = DataBaseConnection::createConnect();
$imageRoot = MAIN;
$priceType = Helper::getDefaultValue(filter_input(INPUT_GET, 'priceType'), "A");
$extraParam = Helper::getDefaultValue(filter_input(INPUT_GET, 'extraParam'), null);
?>

<!DOCTYPE html>
<html lang="th">
    <head>
        <meta charset="utf-8">
        <!--meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" -->
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>ขายสินค้า</title>
        <link rel="stylesheet" href="<?php echo ROOT; ?>/lib-css/bootstrap.min.css"/>
        <link rel="stylesheet" href="<?php echo ROOT; ?>/lib-css/fontawesome-all.min.css"/>
        <link rel="stylesheet" href="<?php echo ROOT; ?>/css/distributor.css"/>
        <script src="<?php echo ROOT; ?>/lib-js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo ROOT; ?>/lib-js/bootstrap.min.js"></script>
        <script src="<?php echo ROOT; ?>/lib-js/popper.min.js"></script>
        <script src="<?php echo ROOT; ?>/lib-js/handlebars-v4.0.11.js"></script>
        <script src="<?php echo ROOT; ?>/js/Ajax.js"></script>
        <script src="<?php echo ROOT; ?>/js/distributor.js"></script>
    </head>

    <body>
        <?php
        include(DOCUMENT_ROOT . "/include/brand.php");
        ?>
        <div class="container-fluid bg-brown" id="productOptionPlaceholder"></div>
        <div class="container-fluid bg-brown">
            <ul class="product-row" id="productPlaceholder"></ul>
        </div>
        <img src="<?php echo WEB_ROOT ?>/image/loading.gif" class="scroll-check-point invisible"/>
    </body>
</html>
<script id="productOptionTemplate" type="text/x-handlebars-template">
    {{#each this.products}}
    <ul class="product-row">
        <li class="product__column product__column--main">
            <a class="product__link bgg-brown" target="_blank" href="<?php echo MAIN ?>distributor.php?show=detail&product_id={{product_id}}&product_sub=1&cate3_id={{../cate3Id}}&cate3_name={{../productName}}">
                <img class="product__link--image" src="<?php echo MAIN ?>pic/product/{{../productName}}/{{product_code}}/{{product_name2}}^1_main.jpg"/>
            </a>
            <div class="product__detail">
                <p class="product__detail product__detail--code">{{product_code}}</p>
            </div>
        </li>
        {{#each product_opts}}
        <li class="product__column product__column--option">
            <div class="product-opt__container bgg-brown">
                <div class="product-opt__container--image">
                    <img class="product-opt product-opt__image" src="<?php echo MAIN ?>pic/product/{{../../productName}}/{{../product_code}}/{{../product_name2}}^{{option_index}}_main.jpg"/>
                    <div class="product-opt product-opt__code">{{product_opt_code}}</div>
                </div>
                <ul class="product-opt__container product-opt__container--detail">
                    <li class="product-opt__detail product-opt__detail--dimension">
                        {{product_opt_dimension}}
                    </li>
                    <li class="product-opt__detail product-opt__detail--costcn">
                        {{product_opt_costcn}}
                    </li>
                    <li class="product-opt__detail product-opt__detail--price">
                        {{price}}
                    </li>
                    <li class="product-opt__detail product-opt__detail--reserve">
                        <button type="button" 
                            class="btn btn-green reserve-button" 
                            product-uid="{{product_uid}}"
                            product-detail="{{product_opt_dimension}}"
                            product-price="{{price}}"
                            image-src="pic/product/{{../../productName}}/{{../product_code}}/{{../product_name2}}^{{option_index}}_main.jpg">
                        จองสินค้า
                        </button>
                    </li>
                </ul>
            </div>
        </li>
        {{/each}}
    </ul>
    {{/each}}
</script>
<script id="productTemplate" type="text/x-handlebars-template">
    {{#each this.products}}
    <li class="product__column product__column--main">
        <a class="product__link" target="_blank" href="<?php echo MAIN ?>distributor.php?show=detail&product_id={{product_id}}&product_sub={{option_index}}&cate3_id={{../cate3Id}}&cate3_name={{../productName}}">
            <img class="product__link--image" src="<?php echo MAIN ?>pic/product/{{../productName}}/{{product_code}}/{{product_name2}}^{{option_index}}_main.jpg"/>
        </a>
        <ul class="product-opt__container product-opt__container bgg-brown">
            <li class="product-opt__detail product-opt__detail--code">
                {{product_code}}^{{option_index}}
            </li>
            <li class="product-opt__detail product-opt__detail--amount">
                {{amount}}
            </li>
            <li class="product-opt__detail product-opt__detail--price">
                {{price}}
            </li>
            <li class="product-opt__detail product-opt__detail--reserve">
                <button type="button" 
                    class="btn btn-green reserve-button" 
                    product-uid="{{product_uid}}" 
                    product-detail="{{product_code}}^{{option_index}}"
                    product-price="{{price}}"
                    image-src="pic/product/{{../productName}}/{{product_code}}/{{product_name2}}^{{option_index}}_main.jpg">
                จองสินค้า
                </button>
            </li>
        </ul>
    </li>
    {{/each}}
</script>
<script>
var distributorOptions = {
    product: {
        url: "<?php echo ROOT ?>/ajax/search.product.php",
        dataSize: 30
    },
    extraParam: <?php echo $extraParam != null ? $extraParam : 'null'; ?>
};
init(distributorOptions);
</script>