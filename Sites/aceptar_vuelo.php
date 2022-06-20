<?php include('templates/header.php');   ?>
<h2 class="title">Aceptar vuelo id_vuelo</h2>

<?php
    require("config/conexion.php");
    $query = "UPDATE vuelo SET  ";
    $result = $db -> prepare($query);
    $result -> execute();
    $vuelos = $result -> fetchAll();
?>

<?php include('templates/footer.php'); ?>