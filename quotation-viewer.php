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
            </div>
            <div class="table-responsive-md">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th scope="col">ลำดับ</th>
                            <th scope="col">รหัส</th>
                            <th scope="col" class="text-center">จำนวน</th>
                            <th scope="col">ราคา</th>
                            <th scope="col">รวม</th>
                        </tr>
                    </thead>
                    <tbody id="quotationDetailPlaceholder">

                    </tbody>
                </table>
            </div>
        </div>
        <img src="<?php echo WEB_ROOT ?>/image/loading.gif" class="scroll-check-point invisible"/>
    </body>
</html>
<script id="quotationDetailTemplate" type="text/x-handlebars-template">
    {{#each this.quotDetail}}
    <tr>
        <td>{{sequence}}</td>
        <td>{{product_uid}}</td>
        <td>{{quantity}}</td>
        <td>{{price}}</td>
        <td>{{total_price}}</td>
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