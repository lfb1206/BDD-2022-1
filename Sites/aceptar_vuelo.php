<?php include('templates/header.php');

$vuelo = $_GET['vuelo']
?>
<h2 class="title">Aceptar vuelo <?php echo "$vuelo" ?></h2>

<div class="buttons">
    <a class="button is-info is-rounded is-outlined is-right" href="sesion_admin.php">
        Volver
    </a>
</div>
<?php include('templates/footer.php'); ?>
