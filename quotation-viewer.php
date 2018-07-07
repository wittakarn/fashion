<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('config.php');
require_once('connection.php');

if (!isset($_SESSION['admin_login'])) {
    if (!$_SESSION['admin_login']) {
        header('Location: ' . MAIN);
        exit();
    }
}
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
        <title>ดูใบเสนอราคา</title>
        <link rel="stylesheet" href="<?php echo ROOT; ?>/lib-css/bootstrap.min.css"/>
        <link rel="stylesheet" href="<?php echo ROOT; ?>/lib-css/fontawesome-all.min.css"/>
        <script src="<?php echo ROOT; ?>/lib-js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo ROOT; ?>/lib-js/bootstrap.min.js"></script>
        <script src="<?php echo ROOT; ?>/lib-js/popper.min.js"></script>
        <script src="<?php echo ROOT; ?>/lib-js/handlebars-v4.0.11.js"></script>
        <script src="<?php echo ROOT; ?>/js/Ajax.js"></script>
        <script src="<?php echo ROOT; ?>/js/quotation-viewer.js"></script>
    </head>

    <body>
        <form method="post" target="_blank" action="submit-quotation.php">
            <div class="container">
                <div class="card">
                    <div class="card-header">เลขที่ใบเสนอราคา</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <input type="text" class="form-control" id="quotationInput">
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-primary" id="fetchDataButton">ดึงข้อมูล</button>
                            </div>
                        </div>
                    </div>
                    <div id="quotationMastPlaceholder" class="card-footer">
                    </div>
                </div>
                <div class="table-responsive-md">
                    <table class="table table-bordered table-dark">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">ลำดับ</th>
                                <th scope="col" class="text-center">รูป</th>
                                <th scope="col" class="text-center">จำนวน</th>
                                <th scope="col" class="text-center">ราคา</th>
                                <th scope="col" class="text-center">รวม</th>
                            </tr>
                        </thead>
                        <tbody id="quotationDetailPlaceholder">

                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </body>
</html>
<script id="quotationMastTemplate" type="text/x-handlebars-template">
    {{#if this}}
    <div class="row">
        <div class="col-2">
            member
            {{#if this.member_id}}
            <input type="hidden" name="memberId" value="{{this.member_id}}"/>
            {{/if}}
        </div>
        <div class="col-2">
            {{this.user}}
        </div>
        <div class="col-2">
            <button type="submit" class="btn btn-primary">ขายสินค้า</button>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            เลขที่บิล
        </div>
        <div class="col-2">
            {{this.quot_no}}
        </div>
        <div class="col-2">
            ราคารวม
        </div>
        <div class="col-2">
            {{this.summary_price}}
        </div>
        <div class="col-2">
            วันที่
        </div>
        <div class="col-2">
            {{this.date}}
        </div>
    </div>
    {{/if}}
</script>
<script id="quotationDetailTemplate" type="text/x-handlebars-template">
    {{#each this}}
    <tr>
        <td>
            {{sequence}}
            <input type="hidden" name="productId[]" value="{{product_id}}"/>
            <input type="hidden" name="productSub[]" value="{{product_sub}}"/>
            <input type="hidden" name="quantity[]" value="{{quantity}}"/>
        </td>
        <td class="text-center"><img class="product-image" src="<?php echo MAIN; ?>{{image_path}}"/></td>
        <td class="text-right">{{quantity}}</td>
        <td class="text-right">{{price}}</td>
        <td class="text-right">{{total_price}}</td>
    </tr>
    {{/each}}
</script>
<script>
var options = {
    quotation: {
        url: "<?php echo ROOT ?>/ajax/search.quotation.php"
    }
};
init(options);
</script>
<style>
    .product-image {
        width: 80px;
    }
</style>