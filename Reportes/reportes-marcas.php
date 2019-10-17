<?php
  //require_once('fpdf.php');
  //require_once('./Controllers/MarcasController.php');
/*
  class PDF extends FPDF
  {
    // Definiendo la cabecera
    function Header()
    {
      $this->SetFont('Arial','B',18);
      $this->Cell(60);
      $this->Cell(70,10,'REPORTE DE MARCAS',1,0,'C');
      $this->Ln(20);
    }
    function Footer()
    {
      $this->SetY(-15);
      $this->SetFont('Arial','I',8);
      $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');
    }

  }
*/

  $marcas_controller = new MarcasController();
  $marcas = $marcas_controller->get();
/*
  $pdf = new FPDF();
  $pdf->AliasNbPages(); // Para determinar el número total de hojas.
  $pdf->AddPage();
  $pdf->SetFont('Arial','B',16);
  // Imprimir los datos.


  $pdf->Output();
*/
  
?>
