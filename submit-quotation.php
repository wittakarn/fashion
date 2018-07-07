<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('config.php');
require_once(DOCUMENT_ROOT . '/class/Helper.php');

$memberId = Helper::getDefaultValue(filter_input(INPUT_POST, 'memberId'), null);
$productIds = Helper::getDefaultValue(filter_input(INPUT_POST, 'productId', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY), null);
$productSubs = Helper::getDefaultValue(filter_input(INPUT_POST, 'productSub', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY), null);
$quantities = Helper::getDefaultValue(filter_input(INPUT_POST, 'quantity', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY), null);

$rowSize = $productIds != null ? count($productIds) : 0;
unset($_SESSION['product_book_array']);
for ($i = 0; $i < $rowSize; $i++) {
    $_SESSION['product_book_array'][$i][0] = $productIds[$i];
    $_SESSION['product_book_array'][$i][1] = $productSubs[$i];
    $_SESSION['product_book_array'][$i][2] = $quantities[$i];
}
?>
<script type = "text/javascript">
    window.location.replace('<?php echo MAIN; ?>admin/page_product_book.php?product_book_status=book&prevent_clear_session=yes<?php echo $memberId != null ? "&member_id={$memberId}" : ""; ?>');
</script>