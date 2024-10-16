<?php

class Estudiante {
    private $id;
    private $nombre;
    private $rut; 
    private $edad; 
    private $carrera;

    public function __construct($id, $nombre, $rut, $edad, $carrera) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->rut = $rut;
        $this->edad = $edad;
        $this->carrera = $carrera;    
    }

    public function crearEstudiante($conn) {
        $stmt = $conn->prepare("INSERT INTO alumnos (nombre, rut, edad, carrera) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("ssis", $this->nombre, $this->rut, $this->edad, $this->carrera);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
    
    public static function listarEstudiantes($conn) {
        $stmt = $conn->prepare("SELECT id, nombre, rut, edad, carrera FROM alumnos");
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $estudiantes = [];
            while ($row = $result->fetch_assoc()) {
                $estudiantes[] = $row;
            }
            $stmt->close();
            return $estudiantes;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function borrarEstudiante($conn) {
        $stmt = $conn->prepare("DELETE FROM alumnos WHERE id = ?");
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("i", $this->id);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function editarEstudiante($conn) {
        $stmt = $conn->prepare("UPDATE alumnos SET nombre = ?, rut = ?, edad = ?, carrera = ? WHERE id = ?");
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("ssisi", $this->nombre, $this->rut, $this->edad, $this->carrera, $this->id);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
}
?>