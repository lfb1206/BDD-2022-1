<?php include('templates/header.php');   ?>
<h2 class="title">Aceptar vuelo <?php echo "$id_vuelo" ?></h2>
<?php
    require("config/conexion.php");
    $query = "UPDATE vuelo 
              SET estado = 'aceptado' 
              WHERE id_vuelo = $id_vuelo";
    $result = $db -> prepare($query);
    $result -> execute();
    $vuelos = $result -> fetchAll();
?>

<?php include('templates/footer.php'); ?>