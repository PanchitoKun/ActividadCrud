<?php
include 'conectar.php';
include 'Plantilla_POO.php';

function validate_input($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $conn = getConnection();
    if ($conn) {
        $stmt = $conn->prepare("SELECT nombre, rut, edad, carrera FROM alumnos WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($nombre, $rut, $edad, $carrera);
            $stmt->fetch();
            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta: " . $conn->error;
        }
        $conn->close();
    } else {
        echo "Error al conectar a la base de datos.";
    }

    if (isset($nombre)) {
        ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Editar Estudiante</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilo.css"> <!-- Added closing quote -->
</head>

<body>
    <div class="container mt-5">
        <h2>Editar Estudiante</h2>
        <form action="editar.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre;?>"
                    required>
            </div>
            <div class="form-group">
                <label for="rut">RUT:</label>
                <input type="text" class="form-control" id="rut" name="rut" value="<?php echo $rut;?>" required>
            </div>
            <div class="form-group">
                <label for="edad">Edad:</label>
                <input type="number" class="form-control" id="edad" name="edad" value="<?php echo $edad;?>" required>
            </div>
            <div class="form-group">
                <label for="carrera">Carrera:</label>
                <input type="text" class="form-control" id="carrera" name="carrera" value="<?php echo $carrera;?>"
                    required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    </div>
</body>

</html>
<?php
    } else {
        echo "No se encontraron datos del estudiante.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = (int) $_POST['id'];
        $nombre = validate_input($_POST['nombre']);
        $rut = validate_input($_POST['rut']);
        $edad = (int) $_POST['edad'];
        $carrera = validate_input($_POST['carrera']);
        
        $estudiante = new Estudiante($id, $nombre, $rut, $edad, $carrera);
        $conn = getConnection();
        
        if ($estudiante->editarEstudiante($conn)) {
            header("Location: agregar.php");
            exit();
        } else {
            echo "<div class='alert alert-danger mt-4' role='alert'>Error al actualizar el estudiante.</div>";
        }
        
        $conn->close();
    }
}
?>