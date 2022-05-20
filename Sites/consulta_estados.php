<?php include('templates/header.html');   ?>

<body>
    <?php
    #Llama a conexión, crea el objeto PDO y obtiene la variable $db
    require("config/conexion.php");

    $nombre_escogido = $_POST["nombre_escogido"];
    $nombre_escogido = strtoupper($nombre_escogido);

    $query = "SELECT CompaniaAerea.nombre_aerolinea, Vuelo.estado, COUNT(Vuelo.id_vuelo) as cantidad
        FROM Vuelo, CompaniaAerea
        WHERE UPPER(CompaniaAerea.nombre_aerolinea) LIKE '%$nombre_escogido%'
        AND CompaniaAerea.codigo_aerolinea = Vuelo.codigo_aerolinea
        GROUP BY CompaniaAerea.nombre_aerolinea, Vuelo.estado;";
    $result = $db -> prepare($query);
    $result -> execute();
    $dataCollected = $result -> fetchAll();
    ?>

    <h1 align="center">
        <?php
        echo "Vuelos por estado de aprobación para la aerolínea \"$nombre_escogido\"";
        ?>
    </h1>
    
    <div class="surface">

        <table>
            <tr>
                <th>Nombre aaerolínea</th>
                <th>Estado</th>
                <th>Cantidad de vuelos</th>
            </tr>
            <?php
            foreach ($dataCollected as $data) {
            echo "<tr> <td>$data[0]</td> <td>$data[1]</td> <td>$data[2]</td> </tr>";
            }
            ?>
        </table>
    </div>

    <?php include('templates/footer.html'); ?>
