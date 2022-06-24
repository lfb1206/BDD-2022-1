<?php include('templates/header.php');  

$vuelo = $_GET['vuelo']
?>

<h2 class="title">Vuelo rechazado</h2>
<?php
    $query = "UPDATE propuesta_vuelo 
              SET estado = 'rechazado' 
              WHERE propuesta_vuelo_id = $vuelo";
    $result = $db2 -> prepare($query);
    $result -> execute();
    $vuelos = $result -> fetchAll();
?>

<div class="buttons" style="justify-content: center;">
    <a class="button is-info is-rounded" href="sesion_admin.php">
        Volver
    </a>
</div>

<?php include('templates/footer.php'); ?>
