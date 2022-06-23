<?php
include './templates/header.php';

$falla_inicio = false;

// Vemos si se esta mandando el form o se está recibiendo
$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
if ($request_method  === 'POST') {
  $query = "
  INSERT INTO Vuelo (username, contrasena, tipo)
  SELECT *
  FROM (
    SELECT 'DGAC' as username, 'admin' as contrasena, 'dgac' as tipo
    UNION ALL
    SELECT CompaniaAerea.codigo_aerolinea as username, CAST(FLOOR(RANDOM()*1000000000) as varchar(255)) as contrasena, 'aerolinea' as tipo
    FROM CompaniaAerea
    UNION ALL
    SELECT Pasajero.pasaporte as username, CONCAT(LEFT(MD5(Pasajero.nombre), 8), LEFT(MD5(Pasajero.pasaporte), 8)) as contrasena, 'pasajero' as tipo
    FROM Pasajero
  ) as Src
  ON CONFLICT (username) DO NOTHING;
  ";
  $q = $db2 -> prepare($query);
  $q -> execute();

  // Aquí se tendría que buscar el id del usuario en la BDD con el mail y la contraseña
  $username = $_POST['username'];
  $password = $_POST['password'];
  //prepare the statement
  $stmt = $db->prepare("SELECT username, tipo FROM usuarios WHERE username=? AND contrasena=?;");
  $stmt->execute([$username, $password]);

  //fetch result
  $user = $stmt->fetch();

  if ($user) {
    // se inicia sesion
    $_SESSION['username'] = $user[0];
    $_SESSION['tipo'] = $user[1];
    // Mandamos al usuario al inicio
    go_home();
  }else{
    // username o contrasena incorrecta
    $falla_inicio = true;
  }
}
$query = "
  SELECT count(Src.username), tipo
  FROM Aerodromo
  WHERE Src.username IN (
    SELECT username FROM Usuarios
  )
  GROUP BY tipo;
  ";
  $q = $db2 -> prepare($query);
  $q -> execute();
  $result = $q -> fetchAll();
// En este caso, que se trata de obtener la página de inicio de sesión
// y no hay una sesión iniciada, se muestra el form
?>


<!-- https://bulma.io/documentation/columns -->
<section class="section">

  <div class="columns is-mobile is-centered is-vcentered cover-all">
    <div class="column is-half">
      <!-- https://bulma.io/documentation/form/general/ -->
      <form method="post">
        <div class="field">
          <label class="label">Codigo</label>
          <div class="control">
            <input class="input" type="text" name="codigo">
          </div>
        </div>
        <div class="field">
          <label class="label">Fecha salida</label>
          <div class="control">
            <input class="input" type="datetime" name="fecha_salida">
          </div>
        </div>
        <div class="field">
          <label class="label">Fecha llegada</label>
          <div class="control">
            <input class="input" type="datetime" name="fecha_llegada">
          </div>
        </div>
        <div class="field">
          <label class="label">Codigo aeronave</label>
          <div class="control">
            <input class="input" type="text" name="aeronave_codigo">
          </div>
        </div>
        <div class="field">
          <label class="label">Aerodromo salida</label>
          <div class="control">
            <input class="input" type="text" name="id_aerodromo_salida">
          </div>
        </div>
        <div class="field">
          <label class="label">Aerodromo llegada</label>
          <div class="control">
            <input class="input" type="text" name="id_aerodromo_llegada">
          </div>
        </div>
        <div class="field">
          <label class="label">Codigo aeronave</label>
          <div class="control">
            <input class="input" type="text" name="aeronave_codigo">
          </div>
        </div>
        <div class="field">
          <label class="label">Codigo aeronave</label>
          <div class="control">
            <input class="input" type="text" name="aeronave_codigo">
          </div>
        </div>
        <button class="button is-primary" type="submit" name="Crear propuesta">Crear propuesta</button>
      </form>

      <?php
      if ($falla_inicio) {
        ?>
        <p class="help is-danger">Nombre de usuario o contraseña incorrecta</p>
        <?php
      }
      ?>
    </div>
  </div>
</section>

<a class="button is-link" href="sesion_aerolineas_aceptado.php">Vuelos aceptados</a>
<a class="button is-link" href="sesion_aerolineas_rechazado.php">Vuelos rechazado</a>

<?php include('templates/footer.php'); ?>
