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
      $this->SetFont('Arial','B',12);
      $this->Cell(60);
      $this->Cell(70,10,'REPORTE DE INVENTARIOS',0,0,'C');
      $this->Ln(20);
      $this->Cell(80,5,'Descripcion',1,0,'C',0);
      $this->Cell(20,5,'N/P',1,0,'C',0);
      $this->Cell(8,5,'Cant',1,0,'C',0); // 1,1 = Salto de Linea
      $this->Cell(20,5,'Fecha',1,0,'C',0); // 1,1 = Salto de Linea
      $this->Cell(30,5,'Marca',1,0,'C',0); // 1,1 = Salto de Linea
      $this->Cell(30,5,'Modelo',1,0,'C',0); // 1,1 = Salto de Linea
      $this->Cell(80,5,'Observaciones',1,1,'C',0); // 1,1 = Salto de Linea
    }
    function Footer()
    {
      $this->SetY(-15);
      $this->SetFont('Arial','I',8);
      $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');
    }

  }


  
  // $pdf = new PDF('L','cm','Letter');
  $pdf = new PDF('L','mm','Letter');
  $pdf->AliasNbPages(); // Para determinar el número total de hojas.
  $pdf->AddPage();
  $pdf->SetFont('Arial','',10);
  // Imprimir los datos.


  $inventario_controller = new InventariosController();
  $inventarios = $inventario_controller->get();
  //Cell(Ancho,Alto,Texto,Border=1,SigLinea=1 0=SinSaltoLinea,'Centrado,Left,Right',Relleno 0=Sin 1=Con)
  // MultiCell(Ancho,AltoFuente(puntos),'Texto Largo',1=Border 0=SinBorder,'Alineacion',Fondo(0=SinFondo))
  for ($n=0;$n<count($inventarios);$n++)
  {
    $pdf->Cell(80,5,$inventarios[$n]['descripcion'],1,0,'L',0);
    $pdf->Cell(20,5,$inventarios[$n]['num_parte'],1,0,'L',0);
    $pdf->Cell(8,5,$inventarios[$n]['existencia'],1,0,'L',0);
    $pdf->Cell(20,5,$inventarios[$n]['fecha'],1,0,'L',0);
    $pdf->Cell(30,5,$inventarios[$n]['marca'],1,0,'L',0);
    $pdf->Cell(30,5,$inventarios[$n]['modelo'],1,0,'L',0);
    $pdf->MultiCell(80,5,$inventarios[$n]['observaciones'],1,'L',0);
  }

  $pdf->Output();
  ob_end_flush();

  
?>
