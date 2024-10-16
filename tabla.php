<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- url de estilos css de boostrap---->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src='main.js'></script>
    <link rel="stylesheet" href="estilo.css"> <!-- Added closing quote -->
</head>

<body>
    <!--esto estara la parte de la tabala -->+
    <div class="table-responsive">



        <div class="container mt-5 table-container">
            <table id="myTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">rut</th>
                        <th scope="col">Edad</th>
                        <th scope="col">Carrera</th>
                        <th scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>1</th>
                        <!------SE AGREGO LA PROPIEDAD DATA-LABEL
                 Lo que hace que los encabezados de columna aparezcan como etiquetas en dispositivos móviles.
                LA TENIAS PUESTA ARRIBA EN LOS ESTILOS, pero o abajo en las etiquetas-->
                        <td data-label="Nombre">Juan</td>
                        <td data-label="Apellido">Gonzales</td>
                        <td data-label="Contrato">Informatica</td>
                        <td data-label="Acción">
                            <a href="agregar.php"><button type="button" class="btn btn-warning">agregar</button></a>
                            <a href="editar.php"><button type="button" href="" class="btn btn-warning"
                                    href="Editar.php">Editar</button></a>
                            <a href="eliminar.php"><button type="button" class="btn btn-danger">Eliminar</button></a>
                        </td>
                    </tr>
                    <tr>
                        <th>2</th>
                        <td data-label="Nombre">Juan</td>
                        <td data-label="Apellido">Gonzales</td>
                        <td data-label="Contrato">Informatica</td>
                        <td data-label="Acción">
                            <a href="agregar.php"><button type="button" class="btn btn-warning">agregar</button></a>
                            <a href="editar.php"><button type="button" href="" class="btn btn-warning"
                                    href="Editar.php">Editar</button></a>
                            <a href="eliminar.php"><button type="button" class="btn btn-danger">Eliminar</button></a>
                        </td>
                    </tr>
                    <tr>
                        <th>3</th>
                        <td data-label="Nombre">Juan</td>
                        <td data-label="Apellido">Gonzales</td>
                        <td data-label="Contrato">Informatica</td>
                        <!--Es la parte de acciones -->
                        <td data-label="Acción">
                            <!--esto son los botones que te derigen a las Accion-->
                            <!--es la tercera casilla -->
                            <a href="agregar.php"><button type="button" class="btn btn-warning">agregar</button></a>
                            <a href="editar.php"><button type="button" href="" class="btn btn-warning"
                                    href="Editar.php">Editar</button></a>
                            <a href="eliminar.php"><button type="button" class="btn btn-danger">Eliminar</button></a>
                        </td>
                    </tr>
                </tbody>
                <?php
                    include 'conectar.php';
                    include 'Plantilla_POO.php';

                    $conn = getConnection();
                    $estudiantes = Estudiante::listarEstudiantes($conn);

                    if ($estudiantes) {
                        foreach ($estudiantes as $estudiante) {
                            echo "<tr>";
                            echo "<td>". htmlspecialchars($estudiante['id']) ."</td>";
                            echo "<td data-label='Nombre'>". htmlspecialchars($estudiante['nombre']) ."</td>";
                            echo "<td data-label='RUT'>". htmlspecialchars($estudiante['rut']) ."</td>";
                            echo "<td data-label='Edad'>". htmlspecialchars($estudiante['edad']) ."</td>";
                            echo "<td data-label='Carrera'>". htmlspecialchars($estudiante['carrera']) ."</td>";
                            echo "<td data-label='Acción'>
                                  <a href='editar.php?id=". $estudiante['id']. "' class='btn btn-warning btn-sm'>Editar</a>
                                  <a href='eliminar.php?id=". $estudiante['id']. "' class='btn btn-danger btn-sm' onclick=\"return confirm('¿Estás seguro de eliminar este registro?')\">Eliminar</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No hay estudiantes registrados</td></tr>";
                    }

                    $conn->close();
                    ?>


            </table>
            <a href="pdf.php"><button type="button" class="btn btn-danger">pdf</button></a>

</body>
</div>

<!--esto es la solucion de la tabla para que no se vea mal para los dispositivos -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<!----jquery-->
<script src="code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<!--poopers-->
<script src="cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
</body>

</html>