<?php include('templates/header.php');   ?>


<?php
#Llama a conexión, crea el objeto PDO y obtiene la variable $db
require("config/conexion.php");
$username = $_SESSION['username']; 
    $query = "SELECT nombre, pasaporte, id_pasajero
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

<?php
#Llama a conexión, crea el objeto PDO y obtiene la variable $db
require("config/conexion.php");
$query = "SELECT id_reserva
            FROM reserva
            WHERE id_eservador = '$dato[2]' ;";
$result2 = $db -> prepare($query);
$result2 -> execute();
$datos2 = $result2 -> fetchAll();

?>
<table>
    <tr>
        <th>Id reservas</th>
    </tr>
    <?php
    foreach ($datos2 as $dato) {
        ?>
        <tr> 
        <td><?php echo "$dato2[0]"; ?></td> 
        </tr>
        <?php
    }
    ?>
</table> 


<?php include('templates/footer.php'); ?>