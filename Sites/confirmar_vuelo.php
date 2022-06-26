<?php include('templates/header.php');  

$id_vuelo = $_GET['vuelo'];
$estado = $_GET['estado'];
if (!($estado === 'aceptado' || $estado === 'rechazado')) {
    echo "Estado de vuelo invalido";
    die();
}

?>

<h2 class="title">Vuelo <?php echo "$estado"; ?></h2>

<?php

# Actualizar propuesta_vuelo en BDD 42 y conseguir datos del vuelo
$query = "UPDATE propuesta_vuelo
            SET estado = '$estado'
            WHERE propuesta_vuelo_id = ?
            RETURNING codigo, fecha_salida, fecha_llegada, aeronave_codigo, id_aerodromo_salida, id_aerodromo_llegada, compagnia_codigo;";
$q = $db2 -> prepare($query);
$q -> execute([$id_vuelo]);
$info_vuelo = $q -> fetch();
$codigo_vuelo = $info_vuelo[0];
$fecha_salida = $info_vuelo[1];
$fecha_llegada = $info_vuelo[2];
$codigo_aeronave = $info_vuelo[3];
$id_aerodromo_salida = $info_vuelo[4];
$id_aerodromo_llegada = $info_vuelo[5];
$codigo_aerolinea = $info_vuelo[6];

# Conseguir codigo ICAO origen
$query = "SELECT Codigo_aerodromo.codigo_icao
          FROM Codigo_aerodromo, Aerodromo
          WHERE Aerodromo.aerodromo_id = ?
          AND Aerodromo.id_codigos = Codigo_aerodromo.id_codigos;";
$q = $db2 -> prepare($query);
$q -> execute([$id_aerodromo_salida]);
$icao_origen = ($q -> fetch())[0];

# Conseguir codigo ICAO destino
$query = "SELECT Codigo_aerodromo.codigo_icao
FROM Codigo_aerodromo, Aerodromo
WHERE Aerodromo.aerodromo_id = ?
AND Aerodromo.id_codigos = Codigo_aerodromo.id_codigos;";
$q = $db2 -> prepare($query);
$q -> execute([$id_aerodromo_llegada]);
$icao_destino = ($q -> fetch())[0];

# Generar datos faltantes
$velocidad = rand(200, 300);
$altitud = rand(10000, 13000);
$id_ruta = rand(1, 331);

# Insertar vuelo en BDD 19
$query = "
    INSERT INTO Vuelo(numero_vuelo, origen_icao, destino_icao, codigo_aerolinea, fecha_salida, fecha_llegada, velocidad, altitud, id_ruta, codigo_aeronave, estado)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '$estado');
";
$result = $db -> prepare($query);
$result -> execute([
    $codigo_vuelo,
    $icao_origen,
    $icao_destino,
    $codigo_aerolinea,
    $fecha_salida,
    $fecha_llegada,
    $velocidad,
    $altitud,
    $id_ruta,
    $codigo_aeronave
]);
?>

<div class="buttons" style="justify-content: center;">
    <a class="button is-info is-rounded" href="sesion_admin.php">
        Volver
    </a>
</div>

<?php include('templates/footer.php'); ?>
