<?php include('templates/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id_vuelo = $_GET['id'];
    $reserve_status = ' ';
    $reserve_message = '';
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_vuelo = $_POST['id_vuelo'];
    $query = "SELECT hacer_reserva(?, ?, array [?, ?, ?]);";
    $q = $db -> prepare($query);
    $q -> execute([$_SESSION['username'], $id_vuelo, $_POST['pasaporte1'], $_POST['pasaporte2'], $_POST['pasaporte3']]);
    $result = $q -> fetch();
    $reserve_status = $result[0][0];
    $reserve_message = substr($result[0], 1);
}

$query = "SELECT Vuelo.numero_vuelo, Aerodromo1.nombre, Aerodromo2.nombre, CompaniaAerea.nombre_aerolinea, Vuelo.fecha_salida, Vuelo.fecha_llegada, Vuelo.codigo_aeronave, Vuelo.estado
        FROM Vuelo, Aerodromo as Aerodromo1, Aerodromo as Aerodromo2, CompaniaAerea
        WHERE Vuelo.id_vuelo = ?
            AND Aerodromo1.codigo_icao = Vuelo.origen_icao
            AND Aerodromo2.codigo_icao = Vuelo.destino_icao
            AND Vuelo.codigo_aerolinea = CompaniaAerea.codigo_aerolinea;";
$q = $db -> prepare($query);
$q -> execute([$id_vuelo]);
$vuelos = $q -> fetchAll();
?>
<table>
    <tr>
        <th>Numero de vuelo</th>
        <th>Aerodromo origen</th>
        <th>Aerodromo destino</th>
        <th>Aerolinea</th>
        <th>Fecha salida</th>
        <th>Fecha llegada</th>
        <th>Codigo aeronave</th>
        <th>Estado</th>
    </tr>
    <?php
    foreach ($vuelos as $vuelo) {?>
        <tr>
            <td><?php echo "$vuelo[0]"; ?></td>
            <td><?php echo "$vuelo[1]"; ?></td>
            <td><?php echo "$vuelo[2]"; ?></td>
            <td><?php echo "$vuelo[3]"; ?></td>
            <td><?php echo "$vuelo[4]"; ?></td>
            <td><?php echo "$vuelo[5]"; ?></td>
            <td><?php echo "$vuelo[6]"; ?></td>
            <td><?php echo "$vuelo[7]"; ?></td>
        </tr>
        <?php
    }
    ?>
</table>

</br>
</br>
<h2 class="title is-4">
    Para realizar una reserva ingresa 
    </br>
    por lo menos un numero de pasaporte 
</h2>   
<div class="columns is-mobile is-centered is-vcentered cover-all">  
    <div class="column is-4">
    <!-- https://bulma.io/documentation/form/general/ -->
        <form method="post" action="consulta_vuelo.php">
            <div class="field">
                <div class="control">
                    <input class="input" type="text" name="pasaporte1" placeholder="Pasaporte primer pasajero">
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <input class="input" type="text" name="pasaporte2" placeholder="Pasaporte segundo pasajero">
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <input class="input" type="text" name="pasaporte3" placeholder="Pasaporte segundo pasajero">
                </div>
            </div>

            <?php
            echo "<input type=\"hidden\" name=\"id_vuelo\" value=\"$id_vuelo\">";
            ?>
            
            <button class="button is-info is-rounded" type="submit" name="Generar reserva">Generar reserva</button>
        </form>
        </br>
        <?php
        if ($reserve_status == '+') {
            ?>
            <p class="help is-success"><?php echo "$reserve_message"; ?></p>
            <?php
        }else if ($reserve_status == '!') {
            ?>
            <p class="help is-danger"><?php echo "$reserve_message"; ?></p>
            <?php
        }
        ?>
        </br>
        <a class="button is-info is-rounded" href="sesion_pasajeros.php">Volver</a>
    </div>
</div>

<?php include('templates/footer.php'); ?>