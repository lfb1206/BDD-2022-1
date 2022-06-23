<?php include('templates/header.php');   ?>


<?php
#Llama a conexión, crea el objeto PDO y obtiene la variable $db
require("config/conexion.php");
if (isset($_POST["fecha_minima"]) and isset($_POST["fecha_maxima"])) {
    $fecha_minima = $_POST["fecha_minima"];
    $fecha_maxima = $_POST["fecha_maxima"];
    $query = "SELECT *
                FROM vuelo
                WHERE estado = 'pendiente' 
                AND '$fecha_minima' <= fecha_salida 
                AND fecha_salida <= '$fecha_maxima'
                ORDER BY fecha_salida;";
    $result = $db -> prepare($query);
    $result -> execute();
    $vuelos = $result -> fetchAll();
} else {
    $query = "SELECT *
                FROM vuelo
                WHERE estado = 'pendiente' ;";
    $result = $db -> prepare($query);
    $result -> execute();
    $vuelos = $result -> fetchAll();
}

?>
<table>
    <tr>
        <th>ID</th>
        <th>codigo</th>
        <th>Aceptar</th>
        <th>Rechazar</th>
    </tr>
    <?php
    foreach ($vuelos as $vuelo) {
        ?>
        <tr> 
        <td><?php echo "$vuelo[0]"; ?></td> 
        <td><?php echo "$vuelo[1]"; ?></td> 
        <td><?php
            echo "<a href=\"aceptar_vuelo.php?vuelo=$vuelo[0]\"> Aceptar </a>"
        ?></td>
        <td><?php
            echo "<a href=\"rechazar_vuelo.php?vuelo=$vuelo[0]\"> Rechazar </a>"
        ?></td>
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