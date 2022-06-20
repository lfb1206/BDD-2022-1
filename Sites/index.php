<?php
require_once "./__init__.php";

// Hay que obtener los pokemones a elegir
// $query = $DB->query('SELECT id, name FROM poke1;');
// $pokemones = $query->fetchAll(PDO::FETCH_ASSOC);
?>

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
      ?> <a class="button is-link" href="sesion_admin.php">Aprobar o rechazar vuelos</button> <?php
    }elseif ($tipo == 'aerolinea') {
      ?> <a class="button is-link" href="sesion_aerolineas.php">Proponer vuelos</button> <?php
    }elseif ($tipo == 'pasajero') {
      ?> <a class="button is-link" href="sesion_pasajeros.php">Reservar</button> <?php
    }
  }
  ?>
</section>

<!-- https://bulma.io/documentation/layout/tiles/ -->
<!-- main class="section">
  <?php if (isset($_SESSION['username'])) { ?>
    <div class="tile is-ancestor">
      <div class="tile is-parent">
        <div class="tile is-child box">
          <h2 class="title">Procedimiento almacenado: Pelea Pokemon</h2>
          <form action='./consultas/crear_pelea_pokemon.php' method='POST'>
            <div class="field is-grouped is-grouped-multiline">
              <div class="control">
                <label class="label" for="pid1">Pokemon 1</label>
                <div class="select">
                  <select name="pid1">
                    <?php foreach ($pokemones as $pokemon) { ?>
                      <option value="<?php echo $pokemon['id'] ?>"><?php echo $pokemon['name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="control">
                <label class="label" for="pid2">Pokemon 2</label>
                <div class="select">
                  <select name="pid2">
                    <?php foreach ($pokemones as $pokemon) { ?>
                      <option value="<?php echo $pokemon['id'] ?>"><?php echo $pokemon['name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <input class='button is-primary' type='submit' value='Crear'>
          </form>
        </div>
      </div>
    </div -->
  <?php } ?>
</main>

<?php include('templates/footer.php'); ?>
