<?php
include 'conectar.php'; 
include 'Plantilla_POO.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $conn = getConnection();
    $estudiante = new Estudiante($id, '', '', '', '');
    
    if ($estudiante->borrarEstudiante($conn)) {
        header("Location: listar.php"); 
        exit(); 
    } else {
        echo "Error al eliminar el estudiante.";
    }
    
    $conn->close();
} else {
    echo "ID de estudiante no proporcionado.";
}
?>