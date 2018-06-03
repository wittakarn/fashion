<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
require_once('config.php');
require_once('connection.php');
$conn = DataBaseConnection::createConnect();
?>
                      
<!DOCTYPE html>
<html lang="th">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ขายสินค้า</title>
  </head>

  <body>
    <?php
      include(DOCUMENT_ROOT."/include/brand.php");
    ?>
  </body>
  <link rel="stylesheet" href="<?php echo ROOT; ?>css/bootstrap.min.css"/>
  <script src="<?php echo ROOT; ?>js/jquery-3.3.1.min.js"></script>
  <script src="<?php echo ROOT; ?>js/bootstrap.min.js"></script>
  <script src="<?php echo ROOT; ?>js/popper.min.js"></script>
</html>