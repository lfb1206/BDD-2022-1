<?php
  try {
    #Pide las variables para conectarse a la base de datos.
    require('data.php'); 
    # Se crea la instancia de PDO
    $db = new PDO("pgsql:dbname=$databaseName;host=$host;port=$port;user=$user;password=$password");
    $db2 = new PDO("pgsql:dbname=$databaseName2;host=$host;port=$port;user=$user2;password=$password2");
  } catch (Exception $e) {
    echo "No se pudo conectar a la base de datos: $e";
  }
?>
