<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('config.php');
require_once('connection.php');
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
        <title>ลูกค้าสั่งสินค้า</title>
        <link rel="stylesheet" href="<?php echo ROOT; ?>/lib-css/bootstrap.min.css"/>
        <link rel="stylesheet" href="<?php echo ROOT; ?>/lib-css/fontawesome-all.min.css"/>
        <link rel="stylesheet" href="<?php echo ROOT; ?>/css/product-order.css"/>
        <script src="<?php echo ROOT; ?>/lib-js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo ROOT; ?>/lib-js/bootstrap.min.js"></script>
        <script src="<?php echo ROOT; ?>/lib-js/popper.min.js"></script>
        <script src="<?php echo ROOT; ?>/lib-js/handlebars-v4.0.11.js"></script>
        <script src="<?php echo ROOT; ?>/js/Ajax.js"></script>
        <script src="<?php echo ROOT; ?>/js/product-order.js"></script>
    </head>

    <body>
        <div class="container-fluid">
            <div class="table-responsive-md">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th scope="col">เลขที่บิล</th>
                            <th scope="col">วัน/เวลา</th>
                            <th scope="col" class="text-center">พิมพ์ไปแล้ว</th>
                            <th scope="col">ชื่อผู้ส่งสินค้า</th>
                            <th scope="col">ชื่อผู้รับสินค้า</th>
                            <th scope="col">Tracking</th>
                            <th scope="col">รายละเอียด</th>
                        </tr>
                    </thead>
                    <tbody id="orderPlaceholder">

                    </tbody>
                </table>
            </div>
        </div>
        <img src="<?php echo WEB_ROOT ?>/image/loading.gif" class="scroll-check-point invisible"/>
    </body>
</html>
<script id="orderTemplate" type="text/x-handlebars-template">
    {{#each this}}
    <tr {{#if isDuplicate}}class="bg-danger"{{/if}}>
        <td>
            <a class="text-white font-weight-bold" href="<?php echo MAIN; ?>admin/order_purchase_all.php?po={{order_purchase_id}}" target="_blank">
            {{order_purchase_id}}
            </a>
        </td>
        <td>
            <p>{{dateTime}}</p>
        </td>
        <td>
            <p class="text-center">{{order_purchase_count_print}}</p>
        </td>
        <td>
            <p>{{member.member_name}}</p>
            <p>{{member.member_phone}}</p>
        </td>
        <td>
            <p>{{customer.customer_name}}</p>
            <p>{{customer.customer_tel}}</p>
            <p>{{customer.customer_address}}</p>
            <p>{{customer.customer_post}}</p>
            <p>{{customer.customer_contact_line}}</p>
            <p>{{customer.customer_contact_fb}}</p>
        </td>
        <td>{{order_purchase_tracking}}</td>
        <td>
            <ul class="product-detail__container">
                {{#each images}}
                <li class="product-image__row">
                    <img class="product-image__picture" src="<?php echo MAIN ?>{{imageSrc}}"/>
                    <p class="text-center">{{stock}}</p>
                </li>
                {{/each}}
            </ul>
        </td>
    </tr>
    {{/each}}
</script>
<script>
var options = {
    order: {
        url: "<?php echo ROOT ?>/ajax/search.purchase.order.php",
        dataSize: 30
    }
};
init(options);
</script>