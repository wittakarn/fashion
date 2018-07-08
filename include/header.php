<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['admin_name']) && !isset($_SESSION['member_name'])) {
    header('Location: ' . MAIN);
    exit();
}

require_once('config.php');
require_once('connection.php');
require_once(DOCUMENT_ROOT . '/class/Helper.php');

$isAdmin = isset($_SESSION['admin_login']) ? $_SESSION['admin_login'] : false;
$priceType = Helper::getDefaultValue(filter_input(INPUT_GET, 'priceType'), null);
?>
<link rel="stylesheet" href="<?php echo ROOT; ?>/css/header.css"/>
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
                <a class="nav-link" href="<?php echo MAIN ?>seller/product-order.php"><h5>แจ้งเลข EMS</h5></a>
            </li>
        </ul>
        <a class="fas fa-shopping-basket fa-2x shopping-icon" href="<?php echo MAIN ?>seller/product-picker.php">
            <div id="productReservedCount" class="product-count">0</div>
        </a>
    </div>
</nav>