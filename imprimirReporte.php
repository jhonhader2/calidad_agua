<?php

require_once('conexion.php');
require_once("librerias/fpdf184/fpdf.php");
require_once('mysql_table.php');

class PDF extends PDF_MySQL_Table
{
    function Header()
    {
        // Title
        $this->SetFont('Arial', '', 18);
        $this->Cell(0, 6, 'Registro de la Toma', 0, 1, 'C');
        $this->Ln(10);
        // Ensure table header is printed
        parent::Header();
    }

}

$id = $_GET['id'];
$query = "SELECT * FROM datos WHERE id = $id";
// $query = "SELECT * FROM datos";

$pdf = new PDF();
$pdf->AddPage();

//Crea la tabla
$pdf->Table($con,$query);

$pdf->Output();