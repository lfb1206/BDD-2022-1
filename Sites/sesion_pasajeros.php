<?php include('templates/header.php');   ?>


<?php
#Llama a conexión, crea el objeto PDO y obtiene la variable $db
require("config/conexion.php");
if (isset($_POST["fecha_minima"]) and isset($_POST["fecha_maxima"])) {
    $fecha_minima = $_POST["fecha_minima"];
    $fecha_maxima = $_POST["fecha_maxima"];
    $query = "SELECT *
                FROM vuelo
                WHERE estado = 'pendiente' 
                AND '$fecha_minima' <= fecha_salida 
                AND fecha_salida <= '$fecha_maxima'
                ORDER BY fecha_salida;";
    $result = $db -> prepare($query);
    $result -> execute();
    $vuelos = $result -> fetchAll();
} 

?>
<table>
    <tr>
        <th>ID</th>
        <th>codigo</th>
        <th>Aceptar</th>
        <th>Rechazar</th>
    </tr>
    <?php
    foreach ($vuelos as $vuelo) {
        ?>
        <tr> 
        <td><?php echo "$vuelo[0]"; ?></td> 
        <td><?php echo "$vuelo[1]"; ?></td> 
        <td><?php
            echo "<a href=\"aceptar_vuelo.php?vuelo=$vuelo[0]\"> Aceptar </a>"
        ?></td>
        <td><?php
            echo "<a href=\"rechazar_vuelo.php?vuelo=$vuelo[0]\"> Rechazar </a>"
        ?></td>
        </tr>
        <?php
    }
    ?>
</table> 

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