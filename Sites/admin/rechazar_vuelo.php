<?php include('../templates/header.php');  

$vuelo = $_GET['vuelo']
?>

<h2 class="title">Rechazar vuelo <?php echo "$vuelo" ?></h2>
<?php
    $query = "UPDATE propuesta_vuelo 
              SET estado = 'rechazado' 
              WHERE propuesta_vuelo_id = $vuelo";
    $result = $db2 -> prepare($query);
    $result -> execute();
    $vuelos = $result -> fetchAll();
?>

<div class="buttons">
    <a class="button is-info is-rounded is-outlined is-right" href="sesion_admin.php">
        Volver
    </a>
</div>

<?php include('../templates/footer.php'); ?>
