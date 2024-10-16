<?php
require('fpdf186/fpdf.php');
include 'conectar.php'; 
include 'Plantilla_POO.php'; 

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Chequeo de existencia de la imagen
        $logoPath = 'images/logo.png';
        if (file_exists($logoPath)) {
            $this->Image($logoPath, 10, 6, 30); // Ruta, posición x, posición y, ancho
        } else {
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(0, 10, 'Logo no encontrado', 0, 1, 'C');
        }
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'Lista de Estudiantes', 0, 1, 'C');
        $this->Ln(20); // Salto de línea para bajar la tabla
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    // Tabla simple
    function BasicTable($header, $data)
    {
        // Cabecera
        foreach ($header as $col) {
            $this->Cell(38, 7, $col, 1);
        }
        $this->Ln();

        // Datos
        foreach ($data as $row) {
            foreach ($row as $col) {
                $this->Cell(38, 6, $col, 1);
            }
            $this->Ln();
        }
    }
}

// Creación del objeto de PDF
$pdf = new PDF();
$pdf->AddPage();

// Títulos de las columnas
$header = array('ID', 'Nombre', 'RUT', 'Edad', 'Carrera');

// Carga de datos
$conn = getConnection();
$estudiantes = Estudiante::listarEstudiantes($conn);
$data = [];

if ($estudiantes) {
    foreach ($estudiantes as $estudiante) {
        $data[] = array(
            $estudiante['id'],
            $estudiante['nombre'],
            $estudiante['rut'],
            $estudiante['edad'],
            $estudiante['carrera']
        );
    }
} else {
    $data[] = array('-', '-', '-', '-', '-');
}

// Imprimir la tabla
$pdf->SetFont('Arial', '', 12);
$pdf->BasicTable($header, $data);

// Cierre del documento y salida del PDF
$pdf->Output('lista_estudiantes.pdf', 'I');
?>