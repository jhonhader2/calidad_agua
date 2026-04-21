<?php

require_once 'conexion.php';
require_once 'librerias/fpdf184/fpdf.php';
require_once 'mysql_table.php';

class PDF extends PDF_MySQL_Table
{
    public function Header()
    {
        // Title
        $this->SetFont('Arial', '', 18);
        $this->Cell(0, 6, 'Registro de la Toma', 0, 1, 'C');
        $this->Ln(10);
        // Ensure table header is printed
        parent::Header();
    }

}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$query = "SELECT * FROM datos WHERE id = $id";

$pdf = new PDF();
$pdf->AddPage();

//Crea la tabla
$pdf->Table($con,$query);

$pdf->Output();
