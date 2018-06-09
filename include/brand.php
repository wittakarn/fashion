<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('config.php');
require_once('connection.php');
require_once(DOCUMENT_ROOT . '/class/Category.php');
require_once(DOCUMENT_ROOT . '/class/Helper.php');
$imageRoot = MAIN;
$priceType = Helper::getDefaultValue(filter_input(INPUT_GET, 'price_type'), "A");
$category3s = Category::getCate3ByCate1Id($conn, 1);
?>

<div class="container-fluid">
    <ul class="nav menu__container">
        <li class="nav-item">
            <a class="nav-link <?php echo $priceType == "A" ? "active" : "" ?>" href="distributor.php?price_type=A"><h5>ตัวแทนสต๊อก</h5></a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $priceType == "B" ? "active" : "" ?>" href="distributor.php?price_type=B"><h5>ตัวแทนไม่สต๊อก</h5></a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $priceType == "C" ? "active" : "" ?>" href="distributor.php?price_type=C"><h5>ราคาปลีก</h5></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../admin/page_main.php"><h5>กลับหน้า Admin</h5></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="quotation_old.php"><h5>ทำใบเสนอเก่า</h5></a>
        </li>
        <li class="nav-item">
            <a class="nav-link"a href="quotation_new.php"><h5>ทำใบเสนอใหม่</h5></a>
        </li>
    </ul>
    <ul class="nav brand__container">
        <?php
        foreach ($category3s as &$category3) {
            echo "<li class='nav-item brand__list'>"
            . "<div cate3-id='{$category3["cate3_id"]}' cate3-name='{$category3["cate3_name"]}' class='nav-link brand__link'>"
            . "<img class='brand__link--image' src='{$imageRoot}pic/brand/{$category3["cate3_name"]}.jpg'>"
            . "</div>"
            . "</li>";
        }
        ?>
    </ul>
</div>
<link rel="stylesheet" href="<?php echo ROOT; ?>/css/brand.css"/>
<script src="<?php echo ROOT; ?>/lib-js/eventemitter.js"></script>
<script src="<?php echo ROOT; ?>/js/brand.js"></script>