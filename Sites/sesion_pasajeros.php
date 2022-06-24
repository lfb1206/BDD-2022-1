<?php include('templates/header.php');

if (isset($_POST["ciudad_origen"]) and isset($_POST["ciudad_destino"]) and isset($_POST["fecha_despegue"])) {
    $ciudad_origen = $_POST["ciudad_origen"];
    $ciudad_destino = $_POST["ciudad_destino"];
    $fecha_despegue = $_POST["fecha_despegue"];
    $query = "SELECT Vuelo.numero_vuelo, Aerodromo1.nombre, Aerodromo2.nombre, CompaniaAerea.nombre_aerolinea, Vuelo.fecha_salida, Vuelo.fecha_llegada, Vuelo.codigo_aeronave, Vuelo.estado, Vuelo.id_vuelo
            FROM Vuelo, Aerodromo as Aerodromo1, Aerodromo as Aerodromo2, CompaniaAerea
            WHERE Vuelo.origen_icao = '$ciudad_origen'
                AND Vuelo.destino_icao = '$ciudad_destino'
                AND Aerodromo1.codigo_icao = '$ciudad_origen'
                AND Aerodromo2.codigo_icao = '$ciudad_destino'
                AND Vuelo.codigo_aerolinea = CompaniaAerea.codigo_aerolinea;";
    $q = $db -> prepare($query);
    $q -> execute();
    $vuelos = $q -> fetchAll();
    ?>
    <table>
        <tr>
            <th>Numero de vuelo</th>
            <th>Aerodromo origen</th>
            <th>Aerodromo destino</th>
            <th>Aerolinea</th>
            <th>Fecha salida</th>
            <th>Fecha llegada</th>
            <th>Codigo aeronave</th>
            <th>Estado</th>
        </tr>
        <?php
        foreach ($vuelos as $vuelo) {
            echo '<a href="consulta_vuelo.php?id='.urlencode($vuelo[8]).'">';?>
                <tr>
                    <td><?php echo "$vuelo[0]"; ?></td>
                    <td><?php echo "$vuelo[1]"; ?></td>
                    <td><?php echo "$vuelo[2]"; ?></td>
                    <td><?php echo "$vuelo[3]"; ?></td>
                    <td><?php echo "$vuelo[4]"; ?></td>
                    <td><?php echo "$vuelo[5]"; ?></td>
                    <td><?php echo "$vuelo[6]"; ?></td>
                    <td><?php echo "$vuelo[7]"; ?></td>
                </tr>
            </a>
            <?php
        }
        ?>
    </table>
    <?php
}
$query = "
  SELECT DISTINCT codigo_icao, nombre
  FROM Aerodromo
  ";
  $q = $db -> prepare($query);
  $q -> execute();
  $result = $q -> fetchAll();
?>


<div class="columns is-mobile is-centered is-vcentered cover-all">
    <div class="column is-half">
    <!-- https://bulma.io/documentation/form/general/ -->
    <form action="sesion_pasajeros.php" method="post">
        <div class="field">
        <label class="label"> Ciudad de origen </label>
        <div class="control">
            <select name="ciudad_origen" id="ar" style="border-radius: 10px; height: 48px;">
              <?php
              foreach ($result as $data) {
                  echo "<option value=\"$data[0]\">$data[1]</option>";
              }
              ?>
            </select>
        </div>
        </div>
        <div class="field">
        <label class="label">Ciudad de destino</label>
        <div class="control">
            <select name="ciudad_destino" id="ar" style="border-radius: 10px; height: 48px;">
              <?php
              foreach ($result as $data) {
                  echo "<option value=\"$data[0]\">$data[1]</option>";
              }
              ?>
            </select>
        </div>
        <label class="label">Fecha de despegue</label>
        <div class="control">
            <input class="input" type="date" name="fecha_despegue">
        </div>
        </div>
        <button class="button is-primary" type="submit" name="login">Recargar</button>
    </form>
    </div>
</div>

<?php include('templates/footer.php'); ?>