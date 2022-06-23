<?php include('templates/header.php');   ?>


<?php
#Llama a conexión, crea el objeto PDO y obtiene la variable $db
require("config/conexion.php");
$username = $_SESSION['username']; 
    $query = "SELECT nombre, pasaporte
                FROM pasajero
                WHERE pasaporte = '$username' ;";
    $result = $db -> prepare($query);
    $result -> execute();
    $datos = $result -> fetchAll();

?>
<table>
    <tr>
        <th>Nombre</th>
        <th>Pasaporte</th>
    </tr>
    <?php
    foreach ($datos as $dato) {
        ?>
        <tr> 
        <td><?php echo "$dato[0]"; ?></td> 
        <td><?php echo "$dato[1]"; ?></td> 
        </tr>
        <?php
    }
    ?>
</table> 

<div class="columns is-mobile is-centered is-vcentered cover-all">
    <div class="column is-half">
    <!-- https://bulma.io/documentation/form/general/ -->
    <form action="sesion_admin.php" method="post">
        <div class="field">
        <label class="label">Fecha minima de los vuelos (yyyy-mm-dd)</label>
        <div class="control">
            <input class="input" type="text" name="fecha_minima">
        </div>
        </div>
        <div class="field">
        <label class="label">Fecha maxima de los vuelos (yyyy-mm-dd)</label>
        <div class="control">
            <input class="input" type="text" name="fecha_maxima">
        </div>
        </div>
        <button class="button is-primary" type="submit" name="login">Recargar</button>
    </form>
    </div>
</div>

<?php include('templates/footer.php'); ?>