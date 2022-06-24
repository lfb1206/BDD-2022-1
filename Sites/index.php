<?php include('templates/header.php'); ?>

<section class="section">
  <?php
  if (isset($_SESSION['username'])) {
    // Se muestra un mensaje si hay una sesión de usuario
    $username = $_SESSION['username'];
    $tipo = $_SESSION['tipo'];
    if ($tipo == 'dgac') {
      ?>
      <h2 class="title is-1"> ¡Hola administrador! </h2> 
      <a class="button is-link" href="sesion_admin.php">Aprobar o rechazar vuelos</a> 
      <?php
    } elseif ($tipo == 'aerolinea') {
      $query2 = "SELECT DISTINCT nombre_aerolinea
                FROM CompaniaAerea
                WHERE $username == codigo_aerolinea;";
      $result2 = $db -> prepare($query2);
      $result2 -> execute();
      $dataCollected2 = $result2 -> fetchAll();
      ?>
      <?php echo "$dataCollected2[0]"; ?>
      <h2 class="title is-1"> Hola <?php echo "$dataCollected2[0]"; ?> </h2>
      <a class="button is-link" href="sesion_aerolineas.php">Proponer vuelos</a>
      <a class="button is-link" href="sesion_aerolineas_aceptado.php">Vuelos aceptados</a>
      <a class="button is-link" href="sesion_aerolineas_rechazado.php">Vuelos rechazado</a> 
      <?php
    } elseif ($tipo == 'pasajero') {
      $query2 = "SELECT DISTINCT nombre
                FROM Pasajero
                WHERE $username == pasaporte;";
      $result2 = $db -> prepare($query2);
      $result2 -> execute();
      $dataCollected2 = $result2 -> fetchAll();
      ?>
      <h2 class="title is-1"> Hola <?php echo "$dataCollected2[0]"; ?> </h2>
      <a class="button is-link" href="sesion_pasajeros.php">Reservar</a>
      <a class="button is-link" href="datos_pasajero.php">Datos</a> 
      <?php
    }
  }
  ?>
</section>

<!-- https://bulma.io/documentation/layout/tiles/ -->
<main class="section">
  <div style="height: 85%; display: flex; align-items: center; justify-content: center;";>
    <div align="center"  class="title is-1 has-text-danger is-active">
      Un espacio para  
      <br/>
      la gestión comercial de vuelos
    </div>
  </div>
</main>

<?php include('templates/footer.php'); ?>
