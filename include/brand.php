<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('config.php');
require_once('connection.php');
require_once(DOCUMENT_ROOT . '/class/Category.php');
require_once(DOCUMENT_ROOT . '/class/Helper.php');

$imageRoot = MAIN;
$priceType = Helper::getDefaultValue(filter_input(INPUT_GET, 'priceType'), null);
$category3s = Category::getCate3ByCate1Id($conn, 1);
?>

<div class="container-fluid without-padding">
    <?php include 'header.php';?>
    <ul class="nav brand__container bgg-darkgreen">
        <?php
        foreach ($category3s as &$category3) {
            echo "<li class='nav-item brand__list'>"
            . "<div cate3-id='{$category3["cate3_id"]}' cate3-name='{$category3["cate3_name"]}' cate3-opt='{$category3["cate3_product_opt"]}' class='nav-link brand__link'>"
            . "<img class='brand__link--image' src='{$imageRoot}pic/brand/{$category3["cate3_name"]}.jpg'>"
            . "</div>"
            . "</li>";
        }
        ?>
    </ul>
</div>
<link rel="stylesheet" href="<?php echo ROOT; ?>/css/main.css"/>
<link rel="stylesheet" href="<?php echo ROOT; ?>/css/brand.css"/>
<script>
    var priceType = "<?php echo $priceType ?>";
</script>
<script src="<?php echo ROOT; ?>/lib-js/eventemitter.js"></script>
<script src="<?php echo ROOT; ?>/js/brand.js"></script>