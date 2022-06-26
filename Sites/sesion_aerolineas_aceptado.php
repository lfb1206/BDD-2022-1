<?php include('templates/header.php');   ?>

<?php

$aerolinea_escogida = $_SESSION['username'];

$query = "SELECT Vuelo.numero_vuelo, Origen.codigo_icao, Origen.nombre as origen,
            Destino.codigo_icao, Destino.nombre as destino,
            Vuelo.fecha_salida, Vuelo.fecha_llegada, Vuelo.estado
          FROM Vuelo, CompaniaAerea, Aerodromo as Origen, Aerodromo as Destino
          WHERE UPPER(CompaniaAerea.codigo_aerolinea) LIKE '%$aerolinea_escogida%'
            AND CompaniaAerea.codigo_aerolinea = Vuelo.codigo_aerolinea 
            AND Vuelo.estado = 'aceptado'
            AND Vuelo.origen_icao = Origen.codigo_icao
            AND Vuelo.destino_icao = Destino.codigo_icao;";
$result = $db -> prepare($query);
$result -> execute();
$dataCollected = $result -> fetchAll();

?>

<?php
echo "<div class=\"title is-4 is-active\" align=\"center\" style=\"color:#006BB3;\">Vuelos aprobados para la aerolínea \"$aerolinea_escogida\"</div> ";
?>

<table>
  <tr>
    <th>Código de vuelo</th>
    <th>ICAO origen</th>
    <th>Aeródromo origen</th>
    <th>ICAO destino</th>
    <th>Aeródromo destino</th>
    <th>Fecha salida</th>
    <th>Fecha llegada</th>
    <th>Estado</th>
  </tr>
<?php
foreach ($dataCollected as $data) {
    echo "<tr>
      <td>$data[0]</td>
      <td>$data[1]</td>
      <td>$data[2]</td>
      <td>$data[3]</td>
      <td>$data[4]</td>
      <td>$data[5]</td>
      <td>$data[6]</td>
      <td>$data[7]</td>
    </tr>";
}
?>
</table>

<a class="button is-info is-rounded" href="sesion_aerolineas.php">Crear propuesta</a>

<?php include('templates/footer.php'); ?>
