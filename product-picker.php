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
        <form id="productPickerForm" method="POST" action="report/quotation.php?submitKey=<?php echo rand(); ?>" target="_blank">
            <div class="container-fluid researve-product__container bg-brown" id="researveProductPlaceholder">
            </div>
        </form>
    </body>
</html>
<script id="researveProductTemplate" type="text/x-handlebars-template">
    <ul class="researve-product researve-product__container bgg-brown">
        <li class="researve-product__detail researve__detail--price-label">
            <span class="summary-data">ราคารวม</span>
        </li>
        <li class="researve-product__detail researve-product__detail--summary-price">
            <span class="summary-data" id="summaryPriceDisplay">{{summaryDisplay}}</span>
            <span class="summary-data">บาท</span>
            <button type="button" 
                class="btn btn-green quotation-button">
            ออกใบเสนอราคา
            </button>
            <input type="hidden" id="summaryPriceInputHidden" name="summaryPrice" value={{summary}}/>
        </li>
    </ul>
    {{#each this}}
    <ul class="researve-product researve-product__container bgg-brown">
        <li class="researve-product__detail researve__detail--image">
            <img class="researve-product__link--image" src="<?php echo MAIN ?>{{imageSrc}}"/>
            <input type="hidden" name="productUid[]" value="{{productUid}}"/>
            <input type="hidden" name="productDetail[]" value="{{productDetail}}"/>
            <input type="hidden" name="productPrice[]" value="{{productPrice}}"/>
            <input type="hidden" name="productTotalPrice[]" value="{{productTotalPrice}}"/>
            <input type="hidden" name="imageSrc[]" value="{{imageSrc}}"/>
        </li>
        <li class="researve-product__detail researve-product__detail--description">
            <p>รายละเอียด</p>
            {{productDetail}}
        </li>
        <li class="researve-product__detail researve-product__detail--quantity">
            <p>จำนวน</p>
            <i class="fas fa-lg fa-border fa-minus-circle quantity__icon quantity__icon--minus"></i>
            <input type="text" name="quantity[]" class="form-control quantity" value="{{quantity}}"/>
            <i class="fas fa-lg fa-border fa-plus-circle quantity__icon quantity__icon--plus"></i>
        </li>
        <li class="researve-product__detail researve-product__detail--button">
            <div>
                <span class="researve-product__detail--price">ราคา</span>
                <span class="researve-product__detail--price">{{productPrice}}</span>
            </div>
            <div>
                <span class="researve-product__detail--price">รวม</span>
                <span class="researve-product__detail--price researve-product__detail--total-price">{{productTotalPrice}}</span>
            </div>
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