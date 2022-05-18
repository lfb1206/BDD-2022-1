<?php include('templates/header.html');   ?>

<body>
  <h1 align="center">Biblioteca Pokemón </h1>
  <p style="text-align:center;">Aquí podrás encontrar información sobre pokemones.</p>

  <br>

  <?php
  #Primero obtenemos todos los tipos de pokemones
  require("config/conexion.php");
  $result = $db -> prepare("SELECT DISTINCT tipo FROM pokemones;");
  $result -> execute();
  $dataCollected = $result -> fetchAll();
  ?>

  <form align="center" action="consultas/consulta_pendiente.php" method="post">
    Seleccinar un tipo:
    <select name="tipo">
      <?php
      #Para cada tipo agregamos el tag <option value=value_of_param> visible_value </option>
      foreach ($dataCollected as $d) {
        echo "<option value=$d[0]>$d[0]</option>";
      }
      ?>
    </select>
    <br><br>
    <input type="submit" value="Buscar por tipo">
  </form>
  
  <br>
  <br>
  <br>

  <h3 align="center"> ¿Quieres buscar un los vuelos aceptados por su aerolínea y el codigo ICAO del aeródromo?</h3>

  <form align="center" action="consultas/consulta_aceptados.php" method="post">
    Aerolínea:
    <input type="text" name="aerolinea_escogida">
    <br/>
    Codigo ICAO:
    <input type="text" name="ICAO_elegido">
    <br/><br/>
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>

  <h3 align="center"> ¿Quieres conocer los tickets asociados a un codigo de reserva?</h3>

  <form align="center" action="consultas/consulta_reserva.php" method="post">
    Codigo de reserva:
    <input type="text" name="codigo_reserva">
    <br/><br/>
    <input type="submit" value="Buscar">
  </form>

  <br>
  <br>
  <br>

  <?php
  #Primero obtenemos todos los tipos de pokemones
  require("config/conexion.php");
  $result = $db -> prepare("SELECT DISTINCT tipo FROM pokemones;");
  $result -> execute();
  $dataCollected = $result -> fetchAll();
  ?>

  <form align="center" action="consultas/consulta_compra.php" method="post">
    Seleccinar un tipo:
    <select name="tipo">
      <?php
      #Para cada tipo agregamos el tag <option value=value_of_param> visible_value </option>
      foreach ($dataCollected as $d) {
        echo "<option value=$d[0]>$d[0]</option>";
      }
      ?>
    </select>
    <br><br>
    <input type="submit" value="Buscar por tipo">
  </form>

  <h3 align="center"> ¿Quieres conocer la cantidad de vuelos por estado asociados a una aerolínea?</h3>

  <form align="center" action="consultas/consulta_.php" method="post">
    Nombre aerolínea:
    <input type="text" name="codigo_reserva">
    <br/><br/>
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>

  <?php
  #Primero obtenemos todos los tipos de pokemones
  require("config/conexion.php");
  $result = $db -> prepare("SELECT DISTINCT tipo FROM pokemones;");
  $result -> execute();
  $dataCollected = $result -> fetchAll();
  ?>

  <form align="center" action="consultas/consulta_compra.php" method="post">
    Seleccinar un tipo:
    <select name="tipo">
      <?php
      #Para cada tipo agregamos el tag <option value=value_of_param> visible_value </option>
      foreach ($dataCollected as $d) {
        echo "<option value=$d[0]>$d[0]</option>";
      }
      ?>
    </select>
    <br><br>
    <input type="submit" value="Buscar por tipo">
  </form>
  
  <br>
  <br>
  <br>
  <br>
</body>
</html>
