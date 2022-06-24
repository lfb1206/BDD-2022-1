<?php include('templates/header.php');

$vuelo = $_GET['vuelo'];
?>
<h2 class="title">Vuelo aceptado</h2>

<?php
    $query = "UPDATE propuesta_vuelo 
              SET estado = 'aceptado' 
              WHERE propuesta_vuelo_id = $vuelo";
    $result = $db2 -> prepare($query);
    $result -> execute();
    $vuelos = $result -> fetchAll();
?>

<?php

    $query2 = "SELECT *
              FROM vuelo 
              WHERE id_vuelo = $vuelo";
    $result2 = $db2 -> prepare($query2);
    $result2 -> execute();
    $vuelos2 = $result2 -> fetchAll();

    $query3 = "SELECT codigo_ICAO
              FROM Codigo_aerodromo, Aerodromo
              WHERE Aerodromo.aerodromo_id = $vuelos2[5]
              AND Aerodromo.id_codigos = Codigo_aerodromo";
    $result3 = $db2 -> prepare($query3);
    $result3 -> execute();
    $icao3 = $result3 -> fetchAll();

    $query4 = "SELECT codigo_ICAO
              FROM Codigo_aerodromo, Aerodromo
              WHERE Aerodromo.aerodromo_id = $vuelos2[6]
              AND Aerodromo.id_codigos = Codigo_aerodromo";
    $result4 = $db2 -> prepare($query4);
    $result4 -> execute();
    $icao4 = $result4 -> fetchAll();

?>
<?php
$velocidad = rand(200, 300);
$altitud = rand(10000, 13000);
$id_ruta = rand(1, 200)
?>

<?php
    $query = "INSERT INTO Vuelo($vuelos2[0], $icao3[0], $icao4[0],$vuelos2[9],$vuelos2[2], $vuelos2[3], $velocidad,  $altitud,  $id_ruta,  $vuelos2[5], 'aceptado') ";
    $result = $db -> prepare($query);
    $result -> execute();
    $vuelos = $result -> fetchAll();
?>


<div class="buttons" style="justify-content: center;">
    <a class="button is-info is-rounded" href="sesion_admin.php">
        Volver
    </a>
</div>
<?php include('templates/footer.php'); ?>
