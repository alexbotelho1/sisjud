<?php
require_once("fpdf/fpdf.php");
define('FPDF_FONTPATH','fpdf/font/');
$pdf = new FPDF("L","cm",array(17.7,22));
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->SetMargins(0,0,0);
$pdf->setY("2.25");
$pdf->setX("11.6");
$pdf->Cell(0, 0, "nodesign");
$pdf->Output("arquivo","I");
?>