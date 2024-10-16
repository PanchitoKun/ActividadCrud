<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Agregar Estudiante</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- URL de estilos CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilo.css"> <!-- Added closing quote -->
</head>

<body>
    <h2>Agregar Estudiante</h2>
    <!-- Formulario -->
    <form action="agregar.php" method="post">
        <!-- Changed action to agregar.php -->
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="rut">RUT:</label>
            <input type="text" class="form-control" id="rut" name="rut" required>
            <?php
            // Validación del RUT después del envío del formulario
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $rut = validarRut($_POST['rut']);
                if (!$rut) {
                    echo "<div class='text-danger'>RUT no válido</div>";
                }
            }

            function validarRut($rut) {
                // Limpiar el Rut de puntos y guiones para dejar sólo dígitos y el dígito verificador
                $rut = preg_replace('/[^0-9kK]/', '', $rut);

                // Separar el Rut de su dígito verificador
                $rut = substr($rut, 0, -1) . '-' . substr($rut, -1);

                // Validar el Rut usando expresión regular
                if (!preg_match('/^(\d{1,3}(?:\.\d{3})*)\-([\dkK])$/', $rut, $matches)) {
                    return false; // formato incorrecto
                }

                // Extraer el número y el dígito verificador
                $numero = $matches[1];
                $dv = strtoupper($matches[2]);

                // Verificar que el dígito verificador sea correcto
                $suma = 0;
                $multiplo = 2;

                for ($i = strlen($numero) - 1; $i >= 0; $i--) {
                    $suma += $numero[$i] * $multiplo;
                    $multiplo = ($multiplo == 7) ? 2 : $multiplo + 1;
                }

                // Calcular el dígito verificador esperado
                $dvEsperado = 11 - ($suma % 11);
                $dvCalculado = ($dvEsperado == 11) ? '0' : (($dvEsperado == 10) ? 'K' : $dvEsperado);

                // Comparar el dígito verificador calculado con el ingresado
                if ($dvCalculado != $dv) {
                    return false; // Rut inválido
                }

                return true; // Rut válido
            }
            ?>
        </div>
        <div class="form-group">
            <label for="edad">Edad:</label>
            <input type="number" class="form-control" id="edad" name="edad" required>
        </div>
        <div class="form-group">
            <label for="carrera">Carrera:</label>
            <input type="text" class="form-control" id="carrera" name="carrera" required>
        </div>
        <button type="submit" class="btn btn-primary">Agregar</button>
        <a href="tabla.php" class="btn btn-primary">Listado</a>
    </form>
    <!-- Fin del formulario -->

    <!-- Solución de la tabla para dispositivos -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <?php
        // Include the necessary files
        include 'Plantilla_POO.php';
        include 'conectar.php';

        function validate_input($data){
            return htmlspecialchars(trim($data));
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = validate_input($_POST['nombre']);
            $rut = validate_input($_POST['rut']);
            $edad = validate_input($_POST['edad']);
            $carrera = validate_input($_POST['carrera']);
            
            // Define the getConnection() function or include the file that contains it
            $conn = getConnection();
            if (!$conn) {
                die("Conexión fallida: " . mysqli_connect_error());
            }

            // Define the Estudiante class or include the file that contains it
            $estudiante = new Estudiante(null, $nombre, $rut, $edad, $carrera);

            if ($estudiante->crearEstudiante($conn)) {
                echo "<div class='alert alert-success mt-4' role='alert'>Nuevo estudiante agregado exitosamente.</div>";
            } else {
                echo "<div class='alert alert-danger mt-4' role='alert'>Error al agregar el estudiante: ". $conn->error. "</div>";
            }
            
            $conn->close();
        }
   ?>
</body>

</html>