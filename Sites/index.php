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
      <a class="button is-link is-rounded" href="sesion_admin.php">Aprobar o rechazar vuelos</a> 
      <?php
    } elseif ($tipo == 'aerolinea') {
      $query = "SELECT nombre_aerolinea
                FROM CompaniaAerea
                WHERE '$username' = codigo_aerolinea;";
      $result = $db -> prepare($query);
      $result -> execute();
      $dataCollected = $result -> fetchAll();
      $aerolinea = $dataCollected[0][0];
      ?>
      <h2 class="title is-1"> Hola <?php echo "$aerolinea"; ?> </h2>
      <a class="button is-link is-rounded" href="sesion_aerolineas.php">Proponer vuelos</a>
      <a class="button is-link is-rounded" href="sesion_aerolineas_aceptado.php">Vuelos aceptados</a>
      <a class="button is-link is-rounded" href="sesion_aerolineas_rechazado.php">Vuelos rechazados</a> 
      <?php
    } elseif ($tipo == 'pasajero') {
      $query = "SELECT DISTINCT nombre
                FROM Pasajero
                WHERE '$username' = pasaporte;";
      $result = $db -> prepare($query);
      $result -> execute();
      $dataCollected = $result -> fetchAll();
      $usuario = $dataCollected[0][0];
      ?>
      <h2 class="title is-1"> Hola <?php echo "$usuario"; ?> </h2>
      <a class="button is-link is-rounded" href="sesion_pasajeros.php">Reservar</a>
      <a class="button is-link is-rounded" href="datos_pasajero.php">Datos</a> 
      <?php
    }
  }
  ?>
</section>

<!-- https://bulma.io/documentation/layout/tiles/ -->
<div class="buttons" style="justify-content: center;">
  <a class="button is-link is-rounded" href="crear_usuarios.php">
      Importar usuarios
  </a>
</div>
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
