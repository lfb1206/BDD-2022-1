<?php include('templates/header.html');?>

<body>


	<?php
	#Llama a conexión, crea el objeto PDO y obtiene la variable $db
	require("config/conexion.php");

	$query = "
MERGE Usuarios as Dst
USING (
	SELECT 'DGAC' as username, 'admin' as contrasena, 'dgac' as tipo
	UNION ALL
	SELECT CompaniaAerea.codigo_aerolinea as username, CAST(FLOOR(RAND()*1000000000) as varchar(255)) as contrasena, 
	FROM CompaniaAerea
	SELECT Pasajero.pasaporte as username, 
	FROM Pasajero 
) as Src
ON Src.username = Dst.username
WHEN NOT MATCHED BY Dst THEN
	INSERT (username, contrasena, tipo)
	VALUES (Src.username, Src.contrasena, Src.tipo);

	";
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
