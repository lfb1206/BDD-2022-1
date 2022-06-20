<?php include('templates/header.php');   
$id_vuelo = $_GET['id_vuelo']
?>

<h2 class="title">Rechazar vuelo</h2>
<?php
    $query = "UPDATE vuelo 
              SET estado = 'rechazado' 
              WHERE id_vuelo = $id_vuelo";
    $result = $db -> prepare($query);
    $result -> execute();
    $vuelos = $result -> fetchAll();
?>

<div class="buttons">
    <a class="button is-info is-rounded is-outlined is-right" href="sesion_admin.php">
        Volver
    </a>
</div>

<?php include('templates/footer.php'); ?>
