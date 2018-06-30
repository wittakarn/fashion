<?php

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once "../config.php";
require_once DOCUMENT_ROOT . '/connection.php';
require_once DOCUMENT_ROOT . '/class/Helper.php';
require_once DOCUMENT_ROOT . '/crud/Quotation.php';
require_once DOCUMENT_ROOT . '/report/QuotDetailPDF.php';
require_once DOCUMENT_ROOT . '/report/tcpdf/tcpdf_config.php';
require_once DOCUMENT_ROOT . '/report/tcpdf/tcpdf.php';

try {
    $productUids = Helper::getDefaultValue(filter_input(INPUT_POST, 'productUid', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY), null);
    $productDetails = Helper::getDefaultValue(filter_input(INPUT_POST, 'productDetail', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY), null);
    $productPrices = Helper::getDefaultValue(filter_input(INPUT_POST, 'productPrice', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY), null);
    $productTotalPrices = Helper::getDefaultValue(filter_input(INPUT_POST, 'productTotalPrice', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY), null);
    $quantities = Helper::getDefaultValue(filter_input(INPUT_POST, 'quantity', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY), null);
    $imageSrcs = Helper::getDefaultValue(filter_input(INPUT_POST, 'imageSrc', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY), null);
    $summaryPrice = Helper::getDefaultValue(filter_input(INPUT_POST, 'summaryPrice', FILTER_DEFAULT), null);
    $submitKey = Helper::getDefaultValue(filter_input(INPUT_GET, 'submitKey', FILTER_DEFAULT), null);

    $detailResults = array();
    $rowSize = $productUids != null ? count($productUids) : 0;

    for ($i = 0; $i < $rowSize; $i++) {
        $detailResults[$i]['sequence'] = $i + 1;
        $detailResults[$i]['product_uid'] = $productUids[$i];
        $detailResults[$i]['product_detail'] = $productDetails[$i];
        $detailResults[$i]['price'] = $productPrices[$i];
        $detailResults[$i]['total_price'] = $productTotalPrices[$i];
        $detailResults[$i]['quantity'] = $quantities[$i];
        $detailResults[$i]['image_path'] = $imageSrcs[$i];
    }
    if (!isset($_SESSION['submitKey']) || $_SESSION['submitKey'] != $submitKey) {
        $quotNo = Quotation::create($summaryPrice, $detailResults);
        $_SESSION['submitKey'] = $submitKey;
    }

    if (isset($quotNo)) {
        // create new PDF document
        $pdf = new QuotDetailPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Wittakarn Keeratichayakorn');
        $pdf->SetTitle('Quotation detail');
        $pdf->SetSubject('Quotation');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set quotation number
        $pdf->setQuotationNumber($quotNo);
        
        // add a page
        $pdf->AddPage();

        // print quotation detail table
        $pdf->generateQuotationDetailTable($detailResults);

        // print table footer
        $pdf->generateQuotationDetailTableFooter($summaryPrice);
        // close and output PDF document
        $pdf->Output('quotation-detail.pdf', 'I');
    } else {
        echo "โปรดทำรายการใหม่อีกครั้ง";
    }
} catch (PDOException $e) {
    unset($_SESSION['submitKey']);
    echo "Failed: " . $e->getMessage();
}
$conn = null;
?>
