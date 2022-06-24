<?php include('templates/header.php');   ?>

<?php
#Llama a conexión, crea el objeto PDO y obtiene la variable $db
if (isset($_POST["fecha_minima"]) and isset($_POST["fecha_maxima"])) {
  $fecha_minima = $_POST["fecha_minima"];
  $fecha_maxima = $_POST["fecha_maxima"];
  $query = "SELECT *
            FROM propuesta_vuelo
            WHERE estado = 'pendiente' 
            AND '$fecha_minima' <= fecha_llegada 
            AND fecha_salida <= '$fecha_maxima'
            ORDER BY fecha_salida;";
  $result = $db2 -> prepare($query);
  $result -> execute();
  $vuelos = $result -> fetchAll();
} else {
  $query = "SELECT *
            FROM propuesta_vuelo
            WHERE estado = 'pendiente' ;";
  $result = $db2 -> prepare($query);
  $result -> execute();
  $vuelos = $result -> fetchAll();
}

?>
  <details>
    <summary class = "title is-5 has-text-black">Filtrar</summary>
    <div class="columns is-mobile is-centered is-vcentered cover-all">
      <div class="column is-4">
        <!-- https://bulma.io/documentation/form/general/ -->
        <form action="sesion_admin.php" method="post">
          <div class="field">
            <div class="control">
              <input text-align="center" class="input" type="date" name="fecha_minima">
            </div>
          </div>
          <div class="field">
            <div class="control">
              <input text-align="center" class="input" type="date" name="fecha_maxima">
            </div>
          </div>
          <button class="button is-info" type="submit" name="login">Filtrar</button>
        </form>
      </div>
    </div>
  </details>

<div class="column is-centered">
  <table>
    <tr>
      <th>ID</th>
      <th>codigo</th>
      <th>Fecha de salida</th>
      <th>Fecha de llegada</th>
      <th>Fecha envio propuesta</th>
      <th>Código de aeronave</th>
      <th>Id aerodromo de salida</th>
      <th>Id aerodromo de llegada</th>
      <th>Estado</th>
      <th>Código de la compania</th>
      <th>Realizado</th>
      <th>Aceptar</th>
      <th>Rechazar</th>
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
          <td><?php echo "$vuelo[8]"; ?></td>
          <td><?php echo "$vuelo[9]"; ?></td>
          <td><?php echo "$vuelo[10]"; ?></td>
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

<?php include('templates/footer.php'); ?>
