<?php include('templates/header.html');   ?>

<body>

<?php
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("config/conexion.php");

  $fecha_minima = $_POST["fecha_minima"];
  $fecha_maxima = $_POST["fecha_maxima"];

  if (empty($fecha_minima) or empty($fecha_maxima)) {
	$query = "SELECT propuesta_vuelo_id, codigo 
              FROM propuesta_vuelo
              WHERE estado = 'pendiente' ;";
	$result = $db -> prepare($query);
	$result -> execute();
	$vuelos = $result -> fetchAll();
    ;}

    else {
 	$query = "SELECT propuesta_vuelo_id, codigo 
              FROM propuesta_vuelo
              WHERE estado = 'pendiente' ;";
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

<?php include('templates/footer.html'); ?>