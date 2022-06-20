<?php
#Llama a conexión, crea el objeto PDO y obtiene la variable $db
require("config/conexion.php");

$query = "
SELECT count(Src.username), tipo
FROM (
	SELECT 'DGAC' as username, 'admin' as contrasena, 'dgac' as tipo
	UNION ALL
	SELECT CompaniaAerea.codigo_aerolinea as username, CAST(FLOOR(RANDOM()*1000000000) as varchar(255)) as contrasena, 'aerolinea' as tipo
	FROM CompaniaAerea
	UNION ALL
	SELECT Pasajero.pasaporte as username, CONCAT(LEFT(MD5(Pasajero.nombre), 8), LEFT(MD5(Pasajero.pasaporte), 8)) as contrasena, 'pasajero' as tipo
	FROM Pasajero 
) as Src
WHERE Src.username IN (
	SELECT username FROM Usuarios
)
GROUP BY tipo;
";
$q = $db -> prepare($query);
$q -> execute();
$result = $q -> fetchAll();

$query = "
MERGE INTO Usuarios as Dst
USING (
	SELECT 'DGAC' as username, 'admin' as contrasena, 'dgac' as tipo
	UNION ALL
	SELECT CompaniaAerea.codigo_aerolinea as username, CAST(FLOOR(RANDOM()*1000000000) as varchar(255)) as contrasena, 'aerolinea' as tipo
	FROM CompaniaAerea
	UNION ALL
	SELECT Pasajero.pasaporte as username, CONCAT(LEFT(MD5(Pasajero.nombre), 8), LEFT(MD5(Pasajero.pasaporte), 8)) as contrasena, 'pasajero' as tipo
	FROM Pasajero 
) as Src
ON Src.username = Dst.username
WHEN NOT MATCHED BY Dst THEN
	INSERT (username, contrasena, tipo)
	VALUES (Src.username, Src.contrasena, Src.tipo);
";
$q = $db -> prepare($query);
$q -> execute();
?>

<?php include('templates/header.php');?>

<body>

	<section class="section">

		<div class="columns is-mobile is-centered is-vcentered cover-all">
			<div class="column is-half">

				<?php
				if (empty($result)) {
					?>
					<h1 class="title">Todos los usuarios fueron creados</h1>
					<?php
				} else {
					?>
					<!-- https://bulma.io/documentation/form/general/ -->
					<h1 class="title">Usuarios que no pudieron ser creados</h1>

					<table>
						<thead>
							<tr>
								<th>Cantidad de usuarios</th>
								<th>Tipo</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($result as $r) {
								echo "<tr>
									<td>$r[0]</td>
									<td>$r[1]</td>
								</tr>";
							}
							?>
						</tbody>
					</table>
					<?php
				}
				?>
			</div>
		</div>
	</section>

	<?php include('templates/footer.php'); ?>
