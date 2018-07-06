<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['admin_name']) && !isset($_SESSION['member_name'])) {
    header('Location: ' . MAIN);
    exit();
}

require_once('config.php');
require_once('connection.php');
require_once(DOCUMENT_ROOT . '/class/Category.php');
require_once(DOCUMENT_ROOT . '/class/Helper.php');
$imageRoot = MAIN;
$isAdmin = isset($_SESSION['admin_login']) ? $_SESSION['admin_login'] : false;
$priceType = Helper::getDefaultValue(filter_input(INPUT_GET, 'priceType'), null);
$category3s = Category::getCate3ByCate1Id($conn, 1);
?>

<div class="container-fluid without-padding">
    <nav class="navbar navbar-expand bg-brown">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Menu navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav menu__container">
                <?php
                if ($isAdmin) {
                    if ($priceType == null) {
                        $priceType = "S";
                    }
                    echo '<li class="nav-item">
                                <a class="nav-link ' . ($priceType == "S" ? "active" : "") . '" href="distributor.php?priceType=S"><h5>ตัวแทนสต๊อก[30+]</h5></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ' . ($priceType == "A" ? "active" : "") . '" href="distributor.php?priceType=A"><h5>ตัวแทนสต๊อก[5+]</h5></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ' . ($priceType == "B" ? "active" : "") . '" href="distributor.php?priceType=B"><h5>ตัวแทนไม่สต๊อก</h5></a>
                            </li>';
                } else {
                    $memberClass = isset($_SESSION['member_class']) ? $_SESSION['member_class'] : null;
                    if ("S" == $memberClass) {
                        if ("S" != $priceType && "C" != $priceType) {
                            $priceType = "S";
                        }
                        echo '<li class="nav-item">
                                    <a class="nav-link ' . ($priceType == "S" ? "active" : "") . '" href="distributor.php?priceType=S"><h5>ตัวแทนสต๊อก[30+]</h5></a>
                                </li>';
                    } else if ("A" == $memberClass) {
                        if ("A" != $priceType && "C" != $priceType) {
                            $priceType = "A";
                        }
                        echo '<li class="nav-item">
                                    <a class="nav-link ' . ($priceType == "A" ? "active" : "") . '" href="distributor.php?priceType=A"><h5>ตัวแทนสต๊อก[5+]</h5></a>
                                </li>';
                    } else if ("B" == $memberClass) {
                        if ("B" != $priceType && "C" != $priceType) {
                            $priceType = "B";
                        }
                        echo '<li class="nav-item">
                                    <a class="nav-link ' . ($priceType == "B" ? "active" : "") . '" href="distributor.php?priceType=B"><h5>ตัวแทนไม่สต๊อก</h5></a>
                                </li>';
                    }
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $priceType == "C" ? "active" : "" ?>" href="distributor.php?priceType=C"><h5>ราคาปลีก</h5></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/page_main.php"><h5>กลับหน้า Admin</h5></a>
                </li>
            </ul>
            <a class="fas fa-shopping-basket fa-2x shopping-icon" href="<?php echo MAIN ?>seller/product-picker.php">
                <div id="productReservedCount" class="product-count">0</div>
            </a>
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