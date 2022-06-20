<?php include('templates/header.html');   ?>

<body>

<?php
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("config/conexion.php");

  $fecha_minima = $_POST["fecha_minima"];
  $fecha_maxima = $_POST["fecha_maxima"];

  if (empty($fecha_minima) or empty($fecha_maxima)) {
	$query = "SELECT id_vuelo, numero_vuelo 
              FROM vuelo
              WHERE estado = 'pendiente' ;";
	$result = $db -> prepare($query);
	$result -> execute();
	$vuelos = $result -> fetchAll();
    ;}

    else {
 	$query = "SELECT id_vuelo, numero_vuelo 
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
    </tr>
  <?php
	foreach ($vuelos as $vuelo) {
  		echo "<tr> <td>$vuelo[0]</td> <td>$vuelo[1]</td> </tr>";
	}
  ?>
	</table> 

    <div class="columns is-mobile is-centered is-vcentered cover-all">
      <div class="column is-half">
        <!-- https://bulma.io/documentation/form/general/ -->
        <form method="post">
          <div class="field">
            <label class="label">Fecha minima de los vuelos</label>
            <div class="control">
              <input class="input" type="text" name="fecha_minima">
            </div>
          </div>
          <div class="field">
            <label class="label">Fecha maxima de los vuelos</label>
            <div class="control">
              <input class="input" type="text" name="fecha_maxima">
            </div>
          </div>
          <button class="button is-primary" type="submit" name="login">Login</button>
        </form>
      </div>
    </div>

<?php include('templates/footer.html'); ?>