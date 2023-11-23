<?php
$servername = "mysql"; // Nombre del servicio de base de datos en Docker Swarm
$username = "root"; // Nombre de usuario de la base de datos
$password = "root1"; // Contraseña de la base de datos
$dbname = "prueba"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta a la tabla
$sql = "SELECT apellidos, nombres, dni FROM alumnos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar los datos de cada fila
    while($row = $result->fetch_assoc()) {
        echo "Apellido: " . $row["apellidos"]. " - Nombre: " . $row["nombres"]. " - Dni: " . $row["dni"]. "<br>";
    }
} else {
    echo "0 resultados";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Aplicación</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<button id="btnSOAP">Consultar con SOAP</button>
<button id="btnREST">Consultar con REST</button>

<div id="resultados">
    <!-- Aquí se mostrarán los resultados de las consultas -->
</div>

<script>
    $(document).ready(function(){
        $("#btnSOAP").click(function(){
            // Llamada a servicio SOAP para ConsultaAlumnosNombres
            $.ajax({
                type: "POST",
                url: "http://soap-servicio:3555/consultar_alumnos",
                contentType: "text/xml",
                data: `
                <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                    <Body>
                        <consultarAlumnosPorNombre xmlns="http://localhost:3555/consultar_alumnos"/>
                    </Body>
                </Envelope>`,
                success: function(dataNombre){
                    // Mostrar los datos en el div 'resultados'
                    $("#resultados").append("<h3>Consulta por Nombre:</h3>");
                    $("#resultados").append(dataNombre);

                    // Llamada a servicio SOAP para ConsultaAlumnosNota
                    $.ajax({
                        type: "POST",
                        url: "http://soap-servicio:3555/consultar_alumnos",
                        contentType: "text/xml",
                        data: `
                        <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                            <Body>
                                <consultarAlumnosPorNota xmlns="http://localhost:3555/consultar_alumnos"/>
                            </Body>
                        </Envelope>`,
                        success: function(dataNota){
                            $("#resultados").append("<h3>Consulta por Nota:</h3>");
                            $("#resultados").append(dataNota);
                        },
                        error: function(error){
                            console.error("Error al hacer la petición SOAP por Nota: ", error);
                        }
                    });
                },
                error: function(error){
                    console.error("Error al hacer la petición SOAP por Nombre: ", error);
                }
            });
        });

        $("#btnREST").click(function(){
            // Llamada a servicio REST para ConsultaAlumnosNombres
            $.get("http://rest-servicio:3000/consultarAlumnosPorApellido", function(dataNombre) {
                $("#resultados").append("<h3>Consulta REST por Nombre:</h3>");
                $("#resultados").append(JSON.stringify(dataNombre));

                // Llamada a servicio REST para ConsultaAlumnosNota
                $.get("http://rest-servicio:3000/consultarAlumnosPorNota", function(dataNota) {
                    $("#resultados").append("<h3>Consulta REST por Nota:</h3>");
                    $("#resultados").append(JSON.stringify(dataNota));
                }).fail(function(error) {
                    console.error("Error al hacer la petición REST por Nota: ", error);
                });
            }).fail(function(error) {
                console.error("Error al hacer la petición REST por Nombre: ", error);
            });
        });
    });
</script>

</body>
</html>



