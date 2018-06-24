<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('config.php');
require_once('connection.php');
require_once(DOCUMENT_ROOT . '/class/Helper.php');
$conn = DataBaseConnection::createConnect();
$imageRoot = MAIN;
$priceType = Helper::getDefaultValue(filter_input(INPUT_GET, 'price_type'), "A");
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
        <link rel="stylesheet" href="<?php echo ROOT; ?>/css/product-picker.css"/>
        <script src="<?php echo ROOT; ?>/lib-js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo ROOT; ?>/lib-js/bootstrap.min.js"></script>
        <script src="<?php echo ROOT; ?>/lib-js/popper.min.js"></script>
        <script src="<?php echo ROOT; ?>/lib-js/handlebars-v4.0.11.js"></script>
        <script src="<?php echo ROOT; ?>/js/helper.js"></script>
        <script src="<?php echo ROOT; ?>/js/product-picker.js"></script>
    </head>

    <body>
        <?php
        include(DOCUMENT_ROOT . "/include/brand.php");
        ?>
        <div class="container-fluid researve-product__container bg-brown" id="researveProductPlaceholder">
        </div>
    </body>
</html>
<script id="researveProductTemplate" type="text/x-handlebars-template">
    <ul class="researve-product researve-product__container bgg-brown">
        <li class="researve-product__detail researve__detail--price-label">
            <span class="summary-data">ราคารวม</span>
        </li>
        <li class="researve-product__detail researve-product__detail--total-price">
            <span class="summary-data" id="summaryPriceDisplay">{{summary}}</span><span class="summary-data">บาท</span>
            <button type="button" 
                class="btn btn-green quotation-button">
            ใบเสนอราคา
            </button>
            <input type="hidden" id="summaryPriceInputHidden" name="summaryPrice[]" value={{productUid}}/>
        </li>
    </ul>
    {{#each this}}
    <ul class="researve-product researve-product__container bgg-brown">
        <li class="researve-product__detail researve__detail--image">
            <img class="researve-product__link--image" src="{{imageSrc}}"/>
            <input type="hidden" name="productUid[]" value={{productUid}}/>
        </li>
        <li class="researve-product__detail researve-product__detail--description">
            <p>รายละเอียด</p>
            {{productDetail}}
        </li>
        <li class="researve-product__detail researve-product__detail--quantity">
            <p>จำนวน</p>
            <input type="text" name="quantity[]" class="form-control quantity" value="1"/>
        </li>
        <li class="researve-product__detail researve-product__detail--button">
            <p class="researve-product__detail--price">ราคา {{productPrice}}</p>
            <button type="button" 
                class="btn btn-default remove-button">
            ลบ
            </button>
        </li>
    </ul>
    {{/each}}
</script>
<script>
options = {
    redirectUrl: '<?php echo MAIN . "seller/distributor.php" ?>'
};
init(options);
</script>