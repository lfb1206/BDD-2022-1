<?php include('templates/header.php'); ?>

<section class="section">
  <?php
  if (isset($_SESSION['username'])) {
    // Se muestra un mensaje si hay una sesión de usuario
    $username = $_SESSION['username'];
    $tipo = $_SESSION['tipo'];
    ?>
    <h2 class="title is-1"> Hola <?php echo "$username"; ?> </h2>
    <?php
    if ($tipo == 'dgac') {
      ?> <a class="button is-link" href="sesion_admin.php">Aprobar o rechazar vuelos</a> <?php
    }elseif ($tipo == 'aerolinea') {
      ?> <a class="button is-link" href="sesion_aerolineas.php">Proponer vuelos</a> <?php
    }elseif ($tipo == 'pasajero') {
      ?> <a class="button is-link" href="sesion_pasajeros.php">Reservar</a> <?php
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
