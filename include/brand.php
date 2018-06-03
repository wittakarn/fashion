<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
require_once('config.php');
require_once('connection.php');
require_once(DOCUMENT_ROOT.'/class/Category.php');
$cate1Id = 1;
$category3s =  Category::getCate3ByCate1Id($conn, $cate1Id);
?>

<ul class="nav">
    <li class="nav-item">
        <a class="nav-link" href="distributor.php?price_type=A"><span>ตัวแทนสต๊อก</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="distributor.php?price_type=B">ตัวแทนไม่สต๊อก</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="distributor.php?price_type=C">ราคาปลีก</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../admin/page_main.php">กลับหน้า Admin</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="quotation_old.php">ทำใบเสนอเก่า</a>
    </li>
    <li class="nav-item">
        <a class="nav-link"a href="quotation_new.php">ทำใบเสนอใหม่</a>
    </li>
</ul>
<ul class="nav">
    <?php
        foreach ($category3s as &$category3) {
            echo "<li class='nav-item'><a class='nav-link' href='distributor.php?brand={$category3["cate3_name"]}&c1={$category3["cate3_id"]}'>{$category3["cate3_name"]}</a></li>";
        }
    ?>
</ul>