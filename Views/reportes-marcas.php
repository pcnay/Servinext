<?php
  //ob_start();
  //ob_clean();
  require_once('./Reportes/fpdf.php');

  while (ob_get_level())
  ob_end_clean();
  header("Content-Encoding: None", true);


  
  class PDF extends FPDF
  {
    // Definiendo la cabecera
    function Header()
    {
      $this->SetFont('Arial','B',18);
      $this->Cell(60);
      $this->Cell(70,10,'REPORTE DE MARCAS',0,0,'C');
      $this->Ln(20);
      $this->Cell(30,10,'Id. Marca',1,0,'C',0);
      $this->Cell(90,10,'Descripcion',1,1,'C',0); // 1,1 = Salto de Linea
    }
    function Footer()
    {
      $this->SetY(-15);
      $this->SetFont('Arial','I',8);
      $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');
    }

  }


  
  $pdf = new PDF();
  $pdf->AliasNbPages(); // Para determinar el número total de hojas.
  $pdf->AddPage();
  $pdf->SetFont('Arial','',16);
  // Imprimir los datos.


  $marcas_controller = new MarcasController();
  $marcas = $marcas_controller->get();
  for ($n=0;$n<count($marcas);$n++)
  {
    $pdf->Cell(30,10,$marcas[$n]['id_marca'],1,0,'C',0);
    $pdf->Cell(90,10,$marcas[$n]['descripcion'],1,1,'C',0);
  }

  $pdf->Output();
  ob_end_flush();

  
?>
