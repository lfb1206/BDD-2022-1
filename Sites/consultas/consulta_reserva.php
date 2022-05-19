<?php include('../templates/header.html');   ?>

<body>

<?php
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("../config/conexion.php");

	$tipo = $_POST["tipo_elegido"];
	$nombre = $_POST["nombre_pokemon"];

 	$query = "SELECT Ticket.id_ticket, Vuelo.numero_vuelo, Origen.nombre as origen,
							Destino.nombre as destino, Vuelo.fecha_salida, Vuelo.fecha_llegada,
							Vuelo.estado, Ticket.numero_asiento, Ticket.clase,
							Ticket.incluye_comida_y_maleta, Pasajero.pasaporte,
							Pasajero.nombre, Costo.precio
						FROM Ticket, Pasajero, Vuelo, Costo, Aerodromo as Origen, Aerodromo as Destino
						WHERE Ticket.id_reserva = codigo_reserva 
							AND ticket.id_pasajero = Pasajero.id_pasajero 
							AND Vuelo.id_vuelo = Ticket.id_vuelo 
							AND Vuelo.id_ruta = Costo.id_ruta
							AND Vuelo.codigo_aeronave = Costo.codigo_aeronave
							AND Vuelo.origen_icao = Origen.codigo_icao
							AND Vuelo.destino_icao = Destino.codigo_icao;";
	$result = $db -> prepare($query);
	$result -> execute();
	$pokemones = $result -> fetchAll();
  ?>

	<table>
    <tr>
      <th>numero_vuelo</th>
      <th>origen_icao</th>
      <th>destino_icao</th>
			<th>fecha_salida</th>
			<th>fecha_llegada</th>
			<th>estado</th>
			<th>numero_asiento</th>
			<th>clase</th>
			<th>incluye_comida_y_maleta</th>
			<th>pasaporte</th>
			<th>nombre precio</th>
    </tr>
  <?php
	foreach ($pokemones as $pokemon) {
  		echo "<tr> <td>$pokemon[0]</td> <td>$pokemon[1]</td> <td>$pokemon[2]</td> <td>$pokemon[0]</td> <td>$pokemon[1]</td> <td>$pokemon[2]</td> <td>$pokemon[0]</td> <td>$pokemon[1]</td> <td>$pokemon[2]</td></tr>";
	}
  ?>
	</table>

<?php include('../templates/footer.html'); ?>
