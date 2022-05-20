<?php include('templates/header.html');   ?>



<body>
  <h1 align="center">Plataforma de gestión comercial de vuelos</h1>

  <div class="surface">
    <h3 align="center">Los vuelos pendientes de aprobación son los siguientes </h3>

    <?php
    # Se buscan los vuelos pendientes
    require("config/conexion.php");
    $result = $db -> prepare("SELECT Vuelo.numero_vuelo, Origen.nombre as origen, Destino.nombre as destino,
                              Vuelo.fecha_salida, Vuelo.fecha_llegada, Vuelo.estado
                            FROM Vuelo, Aerodromo as Origen, Aerodromo as Destino
                            WHERE estado = 'pendiente'
                              AND Vuelo.origen_icao = Origen.codigo_icao
                              AND Vuelo.destino_icao = Destino.codigo_icao;");
    $result -> execute();
    $dataCollected = $result -> fetchAll();
    ?>

    <table>
      <tr>
        <th>Numero</th>
        <th>Aeródromo origen</th>
        <th>Aeródromo destino</th>
        <th>Fecha salida</th>
        <th>Fecha llegada</th>
      </tr>
    <?php
    foreach ($dataCollected as $data) {
        echo "<tr><td>$data[0]</td><td>$data[1]</td><td>$data[2]</td><td>$data[3]</td><td>$data[4]</td></tr>";
    }
    ?>
    </table>
  </div>
  
  <div class="surface">
    <h3 align="center"> ¿Quieres buscar los vuelos aceptados por su aerolínea y el aeródromo de destino?</h3>

    <?php
    # Se buscan los vuelos pendientes
    require("config/conexion.php");
    $result = $db -> prepare("SELECT nombre_aerolinea
                            FROM CompaniaAerea;");
    $result -> execute();
    $dataCollected = $result -> fetchAll();
    ?>

    <form align="center" action="consultas/consulta_aceptados.php" method="post">
      Codigo ICAO destino:
      <input type="text" name="codigo">
      <br/>
      <label for="ar">Aerolínea</label>
        <select name="aerolinea_escogida" id="ar">
          <?php
          foreach ($dataCollected as $data) {
              echo "<option value=\"$data[0]\">$data[0]</option>";
          }
          ?>
        </select>
      <br/><br/>
      <input type="submit" value="Buscar">
    </form>
  </div>
  
  <div class="surface">
    <h3 align="center"> ¿Quieres conocer los tickets asociados a un codigo de reserva?</h3>

    <form align="center" action="consultas/consulta_reserva.php" method="post">
      Codigo de reserva:
      <input type="text" name="codigo_reserva">
      <br/><br/>
      <input type="submit" value="Buscar">
    </form>
  </div>
  
  <div class="surface">
    <h3 align="center"> El(Los) cliente(s) con mayor cantidad de tickets por aerolinea es(son) el(los) siguiente(s)</h3>

    <?php
    # Se busca el cliente con la mayor cantidad de tickets por aerolinea
    require("config/conexion.php");
    $result = $db -> prepare("SELECT CompaniaAerea.nombre_aerolinea, Pasajero.pasaporte,
                              Pasajero.nombre, Cantidades.cantidad
                            FROM CompaniaAerea, Pasajero, (
                              SELECT Cantidades.codigo_aerolinea, 
                                  MAX(Cantidades.cantidad) as max_cantidad
                              FROM (
                                  SELECT Vuelo.codigo_aerolinea, 
                                      Reserva.id_reservador as id_cliente, COUNT(*) as cantidad
                                  FROM Ticket, Vuelo, Reserva
                                  WHERE Ticket.id_reserva = Reserva.id_reserva
                                      AND Ticket.id_vuelo = Vuelo.id_vuelo
                                  GROUP BY Vuelo.codigo_aerolinea, Reserva.id_reservador
                              ) as Cantidades
                              GROUP BY Cantidades.codigo_aerolinea
                            ) as MaxCantidades, (
                              SELECT Vuelo.codigo_aerolinea, 
                                  Reserva.id_reservador as id_cliente, COUNT(*) as cantidad
                              FROM Ticket, Vuelo, Reserva
                              WHERE Ticket.id_reserva = Reserva.id_reserva
                                  AND Ticket.id_vuelo = Vuelo.id_vuelo
                              GROUP BY Vuelo.codigo_aerolinea, Reserva.id_reservador
                            ) as Cantidades
                            WHERE Cantidades.codigo_aerolinea = MaxCantidades.codigo_aerolinea
                              AND Cantidades.cantidad = MaxCantidades.max_cantidad
                              AND Cantidades.codigo_aerolinea = CompaniaAerea.codigo_aerolinea
                              AND Cantidades.id_cliente = Pasajero.id_pasajero
                            ORDER BY CompaniaAerea.nombre_aerolinea, Pasajero.nombre;");
    $result -> execute();
    $dataCollected = $result -> fetchAll();
    ?>

    <table>
      <tr>
        <th>Nombre aerolínea</th>
        <th>Pasaporte pasajero</th>
        <th>Nombre pasajero</th>
        <th>Cantidad de tickets</th>
      </tr>
      <?php
      foreach ($dataCollected as $data) {
          echo "<tr><td>$data[0]</td><td>$data[1]</td><td>$data[2]</td><td>$data[3]</td></tr>";
      }
      ?>
    </table>
  </div>

  <div class="surface">
    <h3 align="center"> ¿Quieres buscar la cantidad de vuelos por estado de una aerolínea? </h3>

    <form align="center" action="consultas/consulta_estados.php" method="post">
      Nombre Aerolínea:
      <input type="text" name="nombre_escogido">
      <br/><br/>
      <input type="submit" value="Buscar">
    </form>
  </div>
  
  <div class="surface">
    <h3 align="center"> La(s) aerolínea con mayor porcentaje(s) de vuelos aprobados es(son) la siguiente(s)</h3>

    <?php
    # Se busca la aerolinea con el mayor porcentaje de vuelos aceptados
    require("config/conexion.php");
    $result = $db -> prepare("SELECT PorcentajesAprobados.nombre_aerolinea, PorcentajesAprobados.porcentaje
                              FROM (
                                  SELECT porcentaje
                                  FROM (
                                      SELECT CompaniaAerea.nombre_aerolinea,
                                          100 * VuelosAprobados.cantidad_aprobada/VuelosTotales.cantidad 
                                          as porcentaje
                                      FROM CompaniaAerea, (
                                          SELECT codigo_aerolinea, count(id_vuelo) as cantidad_aprobada
                                          FROM Vuelo
                                          WHERE estado = 'aceptado'
                                          GROUP BY codigo_aerolinea
                                      ) as VuelosAprobados, (
                                          SELECT codigo_aerolinea, count(id_vuelo) as cantidad
                                          FROM Vuelo
                                          GROUP BY codigo_aerolinea
                                      ) as VuelosTotales
                                      WHERE CompaniaAerea.codigo_aerolinea = VuelosTotales.codigo_aerolinea 
                                          AND CompaniaAerea.codigo_aerolinea 
                                          = VuelosAprobados.codigo_aerolinea
                                          AND VuelosTotales.cantidad > 0
                                  ) as PorcentajesAprobados
                                  ORDER BY porcentaje DESC
                                  LIMIT 1
                              ) as PorcentajeMayor, (
                                  SELECT CompaniaAerea.nombre_aerolinea,
                                      100 * VuelosAprobados.cantidad_aprobada/VuelosTotales.cantidad 
                                      as porcentaje
                                  FROM CompaniaAerea, (
                                      SELECT codigo_aerolinea, count(id_vuelo) as cantidad_aprobada
                                      FROM Vuelo
                                      WHERE estado = 'aceptado'
                                      GROUP BY codigo_aerolinea
                                  ) as VuelosAprobados, (
                                      SELECT codigo_aerolinea, count(id_vuelo) as cantidad
                                      FROM Vuelo
                                      GROUP BY codigo_aerolinea
                                  ) as VuelosTotales
                                  WHERE CompaniaAerea.codigo_aerolinea = VuelosTotales.codigo_aerolinea 
                                      AND CompaniaAerea.codigo_aerolinea 
                                      = VuelosAprobados.codigo_aerolinea
                                      AND VuelosTotales.cantidad > 0
                              ) as PorcentajesAprobados
                              WHERE PorcentajesAprobados.porcentaje = PorcentajeMayor.porcentaje;");
    $result -> execute();
    $dataCollected = $result -> fetchAll();
    ?>

    <table>
      <tr>
        <th>Nombre aerolínea</th>
        <th>Porcentaje vuelos aprobados</th>
      </tr>
    <?php
    foreach ($dataCollected as $data) {
        echo "<tr><td>$data[0]</td><td>$data[1]</td></tr>";
    }
    ?>
    </table>
  </div>
  
</body>
</html>
