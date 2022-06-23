<?php include('templates/header.php');   ?>

<?php
#Llama a conexión, crea el objeto PDO y obtiene la variable $db
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
} else {
  $query = "SELECT *
            FROM vuelo
            WHERE estado = 'pendiente' ;";
  $result = $db -> prepare($query);
  $result -> execute();
  $vuelos = $result -> fetchAll();
}

?>
<div class="column is-4 is-offset-4">
  <table>
    <tr>
      <th>IDD</th>
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
              echo "<a href=\"rechazar_vuelo.php?vuelo=$vuelo[0]\" > Rechazar </a>"
          ?></td>
        </tr>
        <?php
    }
    ?>
  </table> 
  </div>

  <div class="columns is-mobile is-centered is-vcentered cover-all">
    <div class="column is-4">
      <!-- https://bulma.io/documentation/form/general/ -->
      <form action="sesion_admin.php" method="post">
        <div class="field">
          <div class="control">
            <input text-align="center" class="input" type="date" name="fecha_minima" placeholder="Fecha minima de los vuelos (yyyy-mm-dd)">
          </div>
        </div>
        <div class="field">
          <div class="control">
            <input text-align="center" class="input" type="date" name="fecha_maxima" placeholder="Fecha maxima de los vuelos (yyyy-mm-dd)">
          </div>
        </div>
        <button class="button is-info" type="submit" name="login">Filtrar</button>
      </form>
    </div>
  </div>

<?php include('templates/footer.php'); ?>
