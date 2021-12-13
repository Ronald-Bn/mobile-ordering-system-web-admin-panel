<?php

require "fpdf.php";
include('dbcon.php');

$ref_table = '/Orders/';

$fetchdata = $database->getReference($ref_table)->orderByChild('status')->equalTo($_POST["orders"])->getSnapshot()->getValue();

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
        $orders = '';
        if ($_POST["orders"] == 'pending') {
            $orders = 'Pending Orders';
        } else if ($_POST["orders"] == 'paying') {
            $orders = 'To Pay Orders';
        } else if ($_POST["orders"] == 'shipping') {
            $orders = 'To Ship Orders';
        } else if ($_POST["orders"] == 'receiving') {
            $orders = 'To Receive Orders';
        } else if ($_POST["orders"] == 'completed') {
            $orders = 'Completed Orders';
        } else if ($_POST["orders"] == 'rejected') {
            $orders = 'Cancelled Orders';
        } else {
            $orders = 'Invalid';
        }

        $w = array(20, 30, 40, 50, 60, 70, 80, 90, 120, 160);
        date_default_timezone_set('Asia/Manila');
        $this->SetFont('courier', '', 16);
        $this->Cell(0, 0, $orders, 0, 0, 'C');
        $this->Ln();
        $this->SetFont('courier', '', 10);
        $this->SetY(17);
        $this->Cell($w[2], 0, 'Chasy Products', 0, 0, 'L');
        $this->Cell($w[8], 0, ' ', 0, 0, 'C');
        $this->Cell($w[2], 0, 'From :', 0, 0, 'C');
        $this->Cell($w[0], 0, $_POST["datepicker_one"], 0, 0, 'C');
        $this->Cell($w[2], 0, 'To : ', 0, 0, 'C');
        $this->Cell($w[0], 0, $_POST["datepicker_two"], 0, 0, 'C');
    }

    function headerTable()
    {
        $w = array(20, 30, 40, 50, 60, 70, 80, 90, 120, 160);
        $this->SetY(20);
        $this->SetFont('courier', '', 9);
        $this->Cell($w[2], 8, 'NAME', 1, 0, 'C');
        $this->Cell($w[9], 8, 'ADDRESS', 1, 0, 'C');
        $this->Cell($w[2], 8, 'DATE', 1, 0, 'C');
        $this->Cell($w[0], 8, 'STATUS', 1, 0, 'C');
        $this->Cell($w[0], 8, 'PRICE', 1, 0, 'C');
        $this->Ln();
    }

    function viewTable($fetchdata)
    {
        $w = array(20, 30, 40, 50, 60, 70, 80, 90, 120, 160);
        $this->SetFont('courier', '', 9);

        if ($fetchdata > 0) {
            $i = 0;
            $total_price = 0;
            foreach ($fetchdata as $key => $row) {
                $total_price +=  (int)$row['totalpayment'];

                $this->CellFitScale($w[2], 6, $row['name'], 1, 0, 'C');
                $this->CellFitScale($w[9], 6, $row['address'], 1, 0, 'C');
                $this->CellFitScale($w[2], 6, $row['date'], 1, 0, 'C');
                $this->CellFitScale($w[0], 6, $row['status'], 1, 0, 'C');
                $this->CellFitScale($w[0], 6, number_format($row['totalpayment']), 1, 0, 'R');
                $this->Ln();
            }
            $this->CellFitScale($w[2], 6, ' ', 0, 0, 'C');
            $this->CellFitScale($w[9], 6, ' ', 0, 0, 'C');
            $this->CellFitScale($w[2], 6, ' ', 0, 0, 'C');
            $this->CellFitScale($w[0], 6, 'Total: ', 1, 0, 'C');
            $this->CellFitScale($w[0], 6, $total_price, 1, 0, 'R');
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
$pdf->viewTable($fetchdata);
$pdf->Output();
