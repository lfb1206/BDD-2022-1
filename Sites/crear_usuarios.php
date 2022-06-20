<?php
#Llama a conexión, crea el objeto PDO y obtiene la variable $db
require("config/conexion.php");

$query = "
SELECT count(username), tipo
FROM (
	SELECT 'DGAC' as username, 'admin' as contrasena, 'dgac' as tipo
	UNION ALL
	SELECT CompaniaAerea.codigo_aerolinea as username, CAST(FLOOR(RAND()*1000000000) as varchar(255)) as contrasena, 'aerolinea' as tipo
	FROM CompaniaAerea
	UNION ALL
	SELECT Pasajero.pasaporte as username, (CONVERT(NVARCHAR(8),HashBytes('MD5', Pasajero.nombre),2)+CONVERT(NVARCHAR(8),HashBytes('MD5', Pasajero.pasaporte),2)) as contrasena, 'pasajero' as tipo
	FROM Pasajero 
) as Src, Usuarios as Dst
WHERE Src.username NOT IN Dst.username
GROUP BY tipo;
";
$q = $db -> prepare($query);
$q -> execute();
$result = $q -> fetchAll();

$query = "
MERGE Usuarios as Dst
USING (
	SELECT 'DGAC' as username, 'admin' as contrasena, 'dgac' as tipo
	UNION ALL
	SELECT CompaniaAerea.codigo_aerolinea as username, CAST(FLOOR(RAND()*1000000000) as varchar(255)) as contrasena, 'aerolinea' as tipo
	FROM CompaniaAerea
	UNION ALL
	SELECT Pasajero.pasaporte as username, (CONVERT(NVARCHAR(8),HashBytes('MD5', Pasajero.nombre),2)+CONVERT(NVARCHAR(8),HashBytes('MD5', Pasajero.pasaporte),2)) as contrasena, 'pasajero' as tipo
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

<?php include('templates/header.html');?>

<body>


	<h1 align="center">
		<?php
		echo "Usuarios que no pudieron ser creados"
		?>
	</h1>

	<div class="surface">
		<table>
			<tr>
				<th>Cantidad de usuarios</th>
				<th>Tipo</th>
			</tr>
			<?php
			foreach ($result as $r) {
				echo "<tr>
					<td>$r[0]</td>
					<td>$r[1]</td>
				</tr>";
			}
			?>
		</table>
	</div>

	<?php include('templates/footer.html'); ?>
