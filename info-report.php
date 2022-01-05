<?php

require "fpdf.php";
include('dbcon.php');

$ref_table = '/Orders/';
$ref_cart = '/Cart_List/' . $_POST["cartId"];

$fetchdata = $database->getReference($ref_table)->orderByChild('key')->equalTo($_POST["ordersId"])->getSnapshot()->getValue();

$fetchcart = $database->getReference($ref_cart)->getSnapshot()->getValue();


class myPDF extends FPDF
{

    function CellFit($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $scale = false, $force = true)
    {
        //Get string width
        $str_width = $this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $ratio = ($w - $this->cMargin * 2) / $str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit) {
            if ($scale) {
                //Calculate horizontal scaling
                $horiz_scale = $ratio * 100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET', $horiz_scale));
            } else {
                //Calculate character spacing in points
                $char_space = ($w - $this->cMargin * 2 - $str_width) / max(strlen($txt) - 1, 1) * $this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET', $char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align = '';
        }

        //Pass on to Cell method
        $this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT ' . ($scale ? '100 Tz' : '0 Tc') . ' ET');
    }

    //Cell with horizontal scaling only if necessary
    function CellFitScale($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, true, false);
    }

    //Cell with horizontal scaling always
    function CellFitScaleForce($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, true, true);
    }

    //Cell with character spacing only if necessary
    function CellFitSpace($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, false, false);
    }

    //Cell with character spacing always
    function CellFitSpaceForce($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        //Same as calling CellFit directly
        $this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, false, true);
    }


    function Header()
    {
        $w = array(20, 30, 40, 50, 60, 70, 80, 90, 120, 160);
        date_default_timezone_set('Asia/Manila');
        $this->SetFont('courier', '', 16);
        $this->SetFont('courier', '', 10);
    }

    function headerTable()
    {
        $w = array(20, 30, 40, 50, 60, 70, 80, 90, 120, 160);
        $this->SetFont('courier', '', 9);
    }

    function viewTable($fetchdata, $fetchcart)
    {
        $w = array(20, 30, 40, 50, 60, 70, 80, 90, 120, 160);
        $this->SetFont('courier', '', 10);

        if ($fetchdata > 0) {
            $i = 0;
            foreach ($fetchdata as $key => $row) {

                $receivedate = ' ';
                if (isset($row['receivedate']) == null) {
                    $receivedate = '';
                } else {
                    $receivedate = $row['receivedate'];
                }
                list($value1, $value2) = explode("/", $_POST['cartId']);
                $this->Cell($w[9], 6, 'Order ID : ' . $value2, 0, 0, 'L');
                //
                $this->CellFitScale($w[2], 6, 'Order Time : ', 0, 0, 'R');
                $this->CellFitScale($w[5], 6, $row['date'], 0, 0, 'C');
                $this->Ln();
                $this->Cell($w[9], 6, 'Name : ' . $row['name'], 0, 0, 'L');
                //
                $this->CellFitScale($w[2], 6, 'Approve Time : ', 0,  0, 'R');
                $this->CellFitScale($w[5], 6, $row['confirmdate'], 0, 0, 'C');
                $this->Ln();
                $this->CellFitScale($w[9], 6, 'Phone no. : ' . $row['phone'], 0, 0, 'L');
                //
                $this->CellFitScale($w[2], 6, 'Payment Time : ', 0, 0, 'R');
                $this->CellFitScale($w[5], 6, $row['paymentdate'], 0, 0, 'C');
                $this->Ln();
                $this->CellFitScale($w[9], 6, 'Address : ' . $row['address'], 0, 0, 'L');
                //
                $this->CellFitScale($w[2], 6, 'Ship Time : ', 0, 0, 'R');
                $this->CellFitScale($w[5], 6, $row['shipdate'], 0, 0, 'C');
                $this->Ln();
                $this->CellFitScale($w[9], 6, 'Zip code : ' . $row['zipcode'], 0, 0, 'L');
                //
                $this->CellFitScale($w[2], 6, 'Completed Time : ', 0, 0, 'R');
                $this->CellFitScale($w[5], 6, $receivedate, 0, 0, 'C');
                $this->Ln();
                $this->CellFitScale($w[9], 6, 'Status : ' . $row['status'], 0, 0, 'L');
                $this->Ln();
                $this->CellFitScale($w[9], 6, 'Payment method : ' . $row['payment'], 0, 0, 'L');
                $this->Ln();
                $this->CellFitScale($w[9], 6, 'Total payment: ' . number_format($row['totalpayment']), 0, 0, 'L');
                $this->Ln();
                $this->Ln();
                $this->Cell($w[9], 6, 'Item Name', 1, 0, 'C');
                $this->Cell($w[2], 6, 'Price', 1, 0, 'C');
                $this->Cell($w[1], 6, 'Quantity', 1, 0, 'C');
                $this->Cell($w[2], 6, 'Total', 1, 0, 'C');

                if ($fetchcart > 0) {
                    $total_price = 0;
                    foreach ($fetchcart as $key => $row) {
                        $total_price += (int)$row['totalPrice'];
                        $this->Ln();
                        $this->Cell($w[9], 6, $row['name'], 1, 0, 'C');
                        $this->Cell($w[2], 6, $row['itemprice'], 1, 0, 'C');
                        $this->Cell($w[1], 6, $row['quantity'], 1, 0, 'C');
                        $this->Cell($w[2], 6, $row['totalPrice'], 1, 0, 'C');
                    }
                    $this->Ln();
                    $this->CellFitScale($w[9], 6, ' ', 0, 0, 'C');
                    $this->CellFitScale($w[2], 6, ' ', 0, 0, 'C');
                    $this->CellFitScale($w[1], 6, 'Total: ', 1, 0, 'C');
                    $this->CellFitScale($w[2], 6, $total_price, 1, 0, 'C');
                }
            }
        }
    }


    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'C');
    }
}



$pdf = new myPDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->headerTable();
$pdf->viewTable($fetchdata, $fetchcart);
$pdf->AddPage();
$pdf->SetY(20);
$pdf->Cell(0, 10, 'RECEIPT', 0, 0, 'L');
$pdf->Ln();

$pdf->Image('https://firebasestorage.googleapis.com/v0/b/capstone-project-v-1-3.appspot.com/o/image%2Flast.jpg?alt=media&token=5a8c7feb-403c-4eb9-8d03-d809542cb253', $pdf->GetX(), $pdf->GetY(), 70, 0, 'JPEG');
$pdf->Output();
