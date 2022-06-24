<?php include('templates/header.html');   ?>

<body>
	

	<?php
	#Llama a conexión, crea el objeto PDO y obtiene la variable $db
	require("config/conexion.php");

	$codigo_reserva = $_POST["codigo_reserva"];

	$query = "SELECT Ticket.id_ticket, Vuelo.numero_vuelo, Origen.nombre as origen,
		Destino.nombre as destino, Vuelo.fecha_salida, Vuelo.fecha_llegada,
		Vuelo.estado, Ticket.numero_asiento, Ticket.clase,
		Ticket.incluye_comida_y_maleta, Pasajero.pasaporte,
		Pasajero.nombre, Costo.precio
	FROM Ticket, Pasajero, Vuelo, Costo, Aerodromo as Origen, Aerodromo as Destino
	WHERE Ticket.id_reserva = $codigo_reserva 
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

	<h1 align="center">
		<?php
		echo "Tickets asociados a la reserva #$codigo_reserva"
		?>
	</h1>

	<div class="surface">
		<table>
			<tr>
				<th>ID ticket</th>
				<th>Código de vuelo</th>
				<th>Origen</th>
				<th>Destino</th>
				<th>Fecha de salida</th>
				<th>Fecha de llegada</th>
				<th>Estado</th>
				<th>Número de asiento</th>
				<th>Clase</th>
				<th>Incluye comida y maleta</th>
				<th>Número de pasaporte</th>
				<th>Nombre</th>
				<th>Precio</th>
			</tr>
			<?php
			foreach ($pokemones as $pokemon) {
				$comida_maleta = $pokemon[9] ? 'SI' : 'NO';
				echo "<tr>
					<td>$pokemon[0]</td>
					<td>$pokemon[1]</td>
					<td>$pokemon[2]</td>
					<td>$pokemon[3]</td>
					<td>$pokemon[4]</td>
					<td>$pokemon[5]</td>
					<td>$pokemon[6]</td>
					<td>$pokemon[7]</td>
					<td>$pokemon[8]</td>
					<td>$comida_maleta</td>
					<td>$pokemon[10]</td>
					<td>$pokemon[11]</td>
					<td>$pokemon[12]</td>
				</tr>";
			}
			?>
		</table>
	</div>

	<?php include('templates/footer.html'); ?>
