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

<div class="container-fluid without-padding">
    <nav class="navbar navbar-expand bg-brown">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Menu navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav menu__container">
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
        </div>
    </nav>
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