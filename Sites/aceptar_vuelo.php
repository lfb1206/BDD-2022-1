<?php include('templates/header.php');

$vuelo = $_GET['vuelo'];
?>
<h2 class="title">Aceptar vuelo <?php echo "$vuelo" ?></h2>

<?php
    $query = "UPDATE propuesta_vuelo 
              SET estado = 'aceptado' 
              WHERE propuesta_vuelo_id = $vuelo";
    $result = $db2 -> prepare($query);
    $result -> execute();
    $vuelos = $result -> fetchAll();
?>

<?php
/*
    $query = "SELECT *
              FROM vuelo 
              WHERE id_vuelo = $vuelo";
    $result = $db -> prepare($query);
    $result -> execute();
    $vuelos = $result -> fetchAll();
?>

<?php
    $query = "SELECT *
              FROM dblink
              ('dbname=grupo42e3
               port=5432
               password=grupo42
               user=grupo42', INSERT TO 
              );
    $result = $db -> prepare($query);
    $result -> execute();
    $vuelos = $result -> fetchAll();
*/?>


<div class="buttons">
    <a class="button is-info is-rounded is-outlined is-right" href="sesion_admin.php">
        Volver
    </a>
</div>
<?php include('templates/footer.php'); ?>
