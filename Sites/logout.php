<?php
require_once __DIR__ . "/../config/data.php";

// Se conecta a la BDD
require_once __DIR__ . "/../config/conexion.php";

// Se crea siempre una sesión
session_start();


// Funciones propias de utilidad

/**
 * Volver al inicio, tiene que se llamada antes de entregar HTML.
 */
function go_home() {
  header("Location: " . '/~grupo19/');
  exit();
}
session_destroy();
go_home();
?>