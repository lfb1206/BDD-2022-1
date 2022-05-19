<?php include('../templates/header.html');   ?>

<body>

<?php
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("../config/conexion.php");

	$tipo = $_POST["tipo_elegido"];
	$nombre = $_POST["nombre_pokemon"];

 	$query = " SELECT CompaniaAerea.nombre_aerolinea, Vuelo.estado, COUNT(Vuelo.id)
						FROM Vuelo, CompaniaAerea
						WHERE CompaniaAerea.nombre_aerolinea = nombre_escogido
								AND CompaniaAerea.codigo_aerolinea = Vuelo.codigo_aerolinea
						GROUP BY CompaniaAerea.nombre_aerolinea, Vuelo.estado;";
	$result = $db -> prepare($query);
	$result -> execute();
	$dataCollected = $result -> fetchAll();
  ?>

	<table>
    <tr>
      <th>Nombre aaerolínea</th>
      <th>Estado</th>
      <th>Cantidad de vuelos</th>
    </tr>
  <?php
	foreach ($dataCollected as $data) {
  		echo "<tr> <td>$data[0]</td> <td>$data[1]</td> <td>$data[2]</td> </tr>";
	}
  ?>
	</table>

<?php include('../templates/footer.html'); ?>
