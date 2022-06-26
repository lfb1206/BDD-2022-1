<?php include('templates/header.php');  

$vuelo = $_GET['vuelo'];
$estado = $_GET['estado'];
if (!($estado === 'aceptado' || $estado === 'rechazado')) {
    echo "Estado de vuelo invalido";
    die();
}

?>

<h2 class="title">Vuelo <?php echo "$estado"; ?></h2>

<?php

# Actualizar propuesta_vuelo en BDD 42
$query = "UPDATE propuesta_vuelo 
            SET estado = '$estado'
            WHERE propuesta_vuelo_id = ?;";
$result = $db2 -> prepare($query);
$result -> execute([$vuelo]);

# Conseguir informacion del vuelo?
$query2 = "SELECT *
          FROM vuelo 
          WHERE id_vuelo = ?;";
$result2 = $db2 -> prepare($query2);
$result2 -> execute([$vuelo]);
$vuelos2 = $result2 -> fetchAll();

# Conseguir codigo ICAO origen
$query3 = "SELECT codigo_ICAO
          FROM Codigo_aerodromo, Aerodromo
          WHERE Aerodromo.aerodromo_id = ?
          AND Aerodromo.id_codigos = Codigo_aerodromo;";
$result3 = $db2 -> prepare($query3);
$result3 -> execute([$vuelos2[5]]);
$icao3 = $result3 -> fetchAll();

# Conseguir codigo ICAO destino
$query4 = "SELECT codigo_ICAO
          FROM Codigo_aerodromo, Aerodromo
          WHERE Aerodromo.aerodromo_id = ?
          AND Aerodromo.id_codigos = Codigo_aerodromo;";
$result4 = $db2 -> prepare($query4);
$result4 -> execute([$vuelos2[6]]);
$icao4 = $result4 -> fetchAll();

# Generar datos faltantes
$velocidad = rand(200, 300);
$altitud = rand(10000, 13000);
$id_ruta = rand(1, 200);

# Insertar vuelo en BDD 19
$query = "INSERT INTO Vuelo(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '$estado');";
$result = $db -> prepare($query);
$result -> execute([
    $vuelos2[0],
    $icao3[0],
    $icao4[0],
    $vuelos2[9],
    $vuelos2[2],
    $vuelos2[3],
    $velocidad,
    $altitud,
    $id_ruta,
    $vuelos2[5]
]);
?>

<div class="buttons" style="justify-content: center;">
    <a class="button is-info is-rounded" href="sesion_admin.php">
        Volver
    </a>
</div>

<?php include('templates/footer.php'); ?>
