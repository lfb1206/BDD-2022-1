<?php include('templates/header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT Vuelo.numero_vuelo, Aerodromo1.nombre, Aerodromo2.nombre, CompaniaAerea.nombre_aerolinea, Vuelo.fecha_salida, Vuelo.fecha_llegada, Vuelo.codigo_aeronave, Vuelo.estado
            FROM Vuelo, Aerodromo as Aerodromo1, Aerodromo as Aerodromo2, CompaniaAerea
            WHERE Vuelo.id_vuelo = '$id'
                AND Aerodromo1.origen_icao = Vuelo.origen_icao 
                AND Aerodromo2.destino_icao = Vuelo.destino_icao
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
            <th>Estado</th>
        </tr>
        <?php
        foreach ($vuelos as $vuelo) {
            ?>
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
            <?php
        }
        ?>
    </table>
    <?php
}
?>

<?php
$query = "
  SELECT DISTINCT codigo_icao, nombre
  FROM Aerodromo
  ";
  $q = $db2 -> prepare($query);
  $q -> execute();
  $result = $q -> fetchAll();
?>


<div class="columns is-mobile is-centered is-vcentered cover-all">
    <div class="column is-half">
    <!-- https://bulma.io/documentation/form/general/ -->
    <form action="sesion_admin.php" method="post">
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