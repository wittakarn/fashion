<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once("../config.php");
require_once DOCUMENT_ROOT . '/report/tcpdf/tcpdf_config.php';
require_once DOCUMENT_ROOT . '/report/tcpdf/tcpdf.php';

// extend TCPF columnWidthith custom functions
class QuotDetailPDF extends TCPDF {

    public $columnWidth = array(10, 60, 40, 20, 20, 20);
    private $quotationNumber;

    public function setQuotationNumber($quotNo){
        $this->quotationNumber = $quotNo;
    }
    
    //Page header
    public function Header() {
        // Logo
//        $image_file = K_PATH_IMAGES . 'te-logo.jpg';
//        $this->Image($image_file, PDF_MARGIN_LEFT, 8, 115, '', 'JPEG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('', 'B', 20);
        // Title
        $this->Cell(0, 16, "ใบเสนอราคา - {$this->quotationNumber}", 0, 2, 'C', 0, '', 0, false, 'M', 'B');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-10);
        // Set font
        $this->SetFont('', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'หน้า ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public function generateQuotationMaster($customerData, $quotMast) {

        $this->SetFont('', '', 14);
        $customerDetailheight = 4;
        $customerDetailBorder = 0;
        $customerDetailColumnHeight = 5;
        $isAddYourRef = false;
        $isAddDate = false;
        $strDate = $quotMast['date'];

        $this->MultiCell(30, 12, 'นามลูกค้า' . "\n" . 'CUSTOMER', $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
        $this->MultiCell(100, 12, $customerData['customer_name'], $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
        $customerDetailheight = $customerDetailheight + 12;
        $this->MultiCell(8, 12, '', $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
        $this->MultiCell(12, 12, 'เลขที่', $customerDetailBorder, 'R', 0, 0, '', '', true, 0);
        $this->MultiCell(25, 12, '.....' . $quotMast['quot_no'] . '.....', $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
        $this->Ln();

        $customerAddress = $customerData['address'];
        if ($customerAddress != null && $customerAddress != '') {

            $addressLength = strlen($customerAddress);

            $customerAddressHeight = $customerDetailColumnHeight;

            $customerAddressHeight = $customerAddressHeight * 2.5;
            $this->MultiCell(30, $customerAddressHeight, '', $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
            $this->MultiCell(100, $customerAddressHeight, $customerAddress, $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
            $customerDetailheight = $customerDetailheight + $customerAddressHeight;

            if (!$isAddYourRef) {
                $this->MultiCell(8, $customerAddressHeight, '', $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
                $this->MultiCell(12, $customerAddressHeight, 'อ้างถึง', $customerDetailBorder, 'R', 0, 0, '', '', true, 0);
                $this->MultiCell(25, $customerAddressHeight, '.........................', $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
                $isAddYourRef = true;
            }

            $this->Ln();
        }

        $customerTel = $customerData['tel'];
        if ($customerTel != null && $customerTel != '') {
            $this->MultiCell(30, $customerDetailColumnHeight, '', $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
            $this->MultiCell(100, $customerDetailColumnHeight, 'โทรศัพท์ : ' . $customerTel, $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
            $customerDetailheight = $customerDetailheight + $customerDetailColumnHeight;

            $this->printRefAndDate($strDate, $isAddYourRef, $isAddDate, $customerDetailColumnHeight, $customerDetailBorder);

            $this->Ln();
        }

        $customerFax = $customerData['fax'];
        if ($customerFax != null && $customerFax != '') {
            $this->MultiCell(30, $customerDetailColumnHeight, '', $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
            $this->MultiCell(100, $customerDetailColumnHeight, 'โทรสาร : ' . $customerFax, $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
            $customerDetailheight = $customerDetailheight + $customerDetailColumnHeight;

            $this->printRefAndDate($strDate, $isAddYourRef, $isAddDate, $customerDetailColumnHeight, $customerDetailBorder);

            $this->Ln();
        }

        $customerContact = $customerData['contact'];
        if ($customerContact != null && $customerContact != '') {
            $this->MultiCell(30, $customerDetailColumnHeight, '', $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
            $this->MultiCell(100, $customerDetailColumnHeight, $customerContact, $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
            $customerDetailheight = $customerDetailheight + $customerDetailColumnHeight;

            $this->printRefAndDate($strDate, $isAddYourRef, $isAddDate, $customerDetailColumnHeight, $customerDetailBorder);

            $this->Ln();
        }

        $customerEmail = $customerData['email'];
        if ($customerEmail != null && $customerEmail != '') {
            $this->MultiCell(30, $customerDetailColumnHeight, '', $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
            $this->MultiCell(100, $customerDetailColumnHeight, $customerEmail, $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
            $customerDetailheight = $customerDetailheight + $customerDetailColumnHeight;

            $this->printRefAndDate($strDate, $isAddYourRef, $isAddDate, $customerDetailColumnHeight, $customerDetailBorder);

            $this->Ln();
        }

        //$this->Ln();
        // add rectangle
        $this->RoundedRect(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, 130, $customerDetailheight, 3.50, '1111');
    }

    // Colored table
    public function generateQuotationDetailTable($data) {
        $rowLimit = 5;
        // Colors, line columnWidthidth and bold font
        //$this->SetFillColor(255, 0, 0);
        //$this->SetTextColor(255);
        //$this->SetDracolumnWidthColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B', 12);

        // Header
        $this->MultiCell($this->columnWidth[0], 7, 'ลำดับ' . "\n" . 'ITEM', 1, 'C', 0, 0, '', '', true, 0);
        $this->MultiCell($this->columnWidth[1], 7, 'รูป' . "\n" . 'PICTURE', 1, 'C', 0, 0, '', '', true, 0);
        $this->MultiCell($this->columnWidth[2], 7, 'รายละเอียด' . "\n" . 'DESCRIPTION', 1, 'C', 0, 0, '', '', true, 0);
        $this->MultiCell($this->columnWidth[3], 7, 'จำนวน' . "\n" . 'QUANTITY', 1, 'C', 0, 0, '', '', true, 0);
        $this->MultiCell($this->columnWidth[4], 7, 'ราคา/หน่วย' . "\n" . 'UNIT PRICE', 1, 'C', 0, 0, '', '', true, 0);
        $this->MultiCell($this->columnWidth[5], 7, 'รวมเงิน' . "\n" . 'AMOUNT', 1, 'C', 0, 0, '', '', true, 0);

        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(245, 205, 188);
        //$this->SetTextColor(0);
        $this->SetFont('', '', 12.3);
        // Data
        $fill = 0;

        $rowIndexPerPage = 0;
        $headerHeight = 13;
        foreach ($data as $rocolumnWidth) {

            if ($rowLimit == 0) {
                $this->AddPage();
                $rowLimit = 5;
                $rowIndexPerPage = 0;
                $headerHeight = 3;
                $borderStyle = 'TLRB';
            } else {
                $borderStyle = 'LRB';
            }

            $columnheight = 50;

            $this->MultiCell($this->columnWidth[0], $columnheight, $rocolumnWidth['sequence'], $borderStyle, 'R', $fill, 0, '', '', true, 0);
            $this->MultiCell($this->columnWidth[1], $columnheight, '', $borderStyle, 'C', $fill, 0, '', '', true, 0);
            $this->generateProductImage(MAIN . $rocolumnWidth['image_path'], $headerHeight, 17, 50 * $rowIndexPerPage++);
            $this->MultiCell($this->columnWidth[2], $columnheight, $rocolumnWidth['product_detail'], $borderStyle, 'L', $fill, 0, '', '', true, 0);
            $this->MultiCell($this->columnWidth[3], $columnheight, number_format($rocolumnWidth['quantity'], 1), $borderStyle, 'R', $fill, 0, '', '', true, 0);
            $this->MultiCell($this->columnWidth[4], $columnheight, number_format($rocolumnWidth['price'], 2), $borderStyle, 'R', $fill, 0, '', '', true, 0);
            $this->MultiCell($this->columnWidth[5], $columnheight, number_format($rocolumnWidth['total_price'], 2), $borderStyle, 'R', $fill, 0, '', '', true, 0);
            $this->Ln();
            $rowLimit--;
        }
    }

    public function generateQuotationDetailTableFooter($summaryPrice) {
        $this->SetFont('', 'B', 18);
        $columnWidth = 5;
        $this->MultiCell($this->columnWidth[0], $columnWidth, '', 0, 'C', 0, 0, '', '', true, 0);
        $this->MultiCell($this->columnWidth[1], $columnWidth, '', 0, 'C', 0, 0, '', '', true, 0);
        $this->MultiCell($this->columnWidth[2] + $this->columnWidth[3], $columnWidth, 'จำนวนเงิน', 0, 'R', 0, 0, '', '', true, 0);
        $this->MultiCell($this->columnWidth[4] + $this->columnWidth[5], $columnWidth, number_format((double)$summaryPrice, 2), 'LRB', 'R', 0, 0, '', '', true, 0);
        $this->Ln();
    }

    public function generateProductImage($img, $headerHeight, $paddingX, $paddingY) {
        $imageSquareWidth = 45;
        $positionX = PDF_MARGIN_LEFT + $paddingX;
        $positionY = PDF_MARGIN_TOP + $headerHeight + $paddingY;
        //echo $positionX.'/'.$positionY.',';
        $this->Image($img, $positionX, $positionY, $imageSquareWidth, $imageSquareWidth, '', '', '', false, 300, '', false, false, 0, false, false, false);
    }

    public function printRefAndDate($strDate, &$isAddYourRef, &$isAddDate, $customerDetailColumnHeight, $customerDetailBorder) {
        if (!$isAddYourRef) {
            $this->MultiCell(8, $customerDetailColumnHeight, '', $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
            $this->MultiCell(12, $customerDetailColumnHeight, 'อ้างถึง', $customerDetailBorder, 'R', 0, 0, '', '', true, 0);
            $this->MultiCell(25, $customerDetailColumnHeight, '.........................', $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
            $isAddYourRef = true;
        }

        if ($isAddYourRef && !$isAddDate) {
            $this->MultiCell(8, $customerDetailColumnHeight, '', $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
            $this->MultiCell(12, $customerDetailColumnHeight, 'วันที่', $customerDetailBorder, 'R', 0, 0, '', '', true, 0);
            $this->MultiCell(25, $customerDetailColumnHeight, '..' . self::formatDateThai($strDate) . '..', $customerDetailBorder, 'L', 0, 0, '', '', true, 0);
            $isAddDate = true;
        }
    }

    public static function formatDateThai($strDate) {
        $dmy = explode("-", $strDate);
        $y = $dmy[0];
        $m = $dmy[1];
        $d = $dmy[2];
        return $d . '/' . $m . '/' . $y;
    }

    public static function removeBlanket($str) {
        $patterns = array();
        $patterns[0] = "/\{([^}]+)\}/";
        $patterns[1] = "/\[([^]]+)\]/";
        $replacements = array();
        $replacements[2] = '';
        $replacements[1] = '';
        return preg_replace($patterns, $replacements, $str);
    }

}

?>