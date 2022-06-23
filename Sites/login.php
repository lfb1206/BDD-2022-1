<?php
include './templates/header.php';

$falla_inicio = false;

// Vemos si se esta mandando el form o se está recibiendo
$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
if ($request_method  === 'POST') {
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
          <label class="label">Nombre de usuario</label>
          <div class="control">
            <input class="input" type="text" name="username">
          </div>
        </div>
        <div class="field">
          <label class="label">Contraseña</label>
          <div class="control">
            <input class="input" type="password" name="password">
          </div>
        </div>
        <button class="button is-primary" type="submit" name="login">Login</button>
      </form>

      <?php
      if ($falla_inicio) {
        ?>
        <p class="help is-danger">Nombre de usuario o contraseña incorrecta</p>
        <?php
      }
      ?>
      <div class="buttons" align-item="center">
        <a class="button is-info is-rounded is-outlined is-right" href="crear_usuarios.php">
            Importar usuarios
        </a>
      </div>
    </div>
  </div>
</section>

<?php include './templates/footer.php'; ?>

