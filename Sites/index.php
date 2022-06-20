<?php
require_once "./__init__.php";

// Hay que obtener los pokemones a elegir
// $query = $DB->query('SELECT id, name FROM poke1;');
// $pokemones = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include('templates/header.html'); ?>

<section class="hero is-success is-halfheight pokebaner">
  <div class="hero-body">
    <h1 class="title">PokeDB</h1>
  </div>
</section>

<section class="section">
  <?php if (isset($_SESSION['user_name'])) { ?>
    <!-- Se muestra un mensaje si hay una sesión de usuario -->
    <h2 class="title is-1"> Hola <?php echo $_SESSION['user_name'] ?></h2>
    <form class="buttons" action="logout.php">
      <input class="button" type="submit" value="Cerrar Sesión">
    </form>
  <?php } else { ?>
    <!-- En el caso que no, se muestran los botones para iniciar sesión -->
    <div class="buttons">
      <a class="button is-primary" href="crear_usuarios.php">
        Importar usuarios
      </a>
      <a href="login.php" class="button is-light">
        Iniciar sesión
      </a>
    </div>
  <?php } ?>
</section>

<!-- https://bulma.io/documentation/layout/tiles/ -->
<main class="section">
  <?php if (isset($_SESSION['user_id'])) { ?>
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
    </div>
  <?php } ?>
</main>

<?php include('templates/footer.html'); ?>
