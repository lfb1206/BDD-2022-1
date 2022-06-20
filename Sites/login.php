<?php
require_once './__init__.php';

// HOLA
// Vemos si se esta mandando el form o se está recibiendo
$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
if ($request_method  === 'POST') {
  // Se está recibiendo datos para el login
  session_start();
  // Aquí se tendría que buscar el id del usuario en la BDD con el mail y la contraseña
  $user_name = $_POST['username'];
  $password = $_POST['password'];

  // Se guardan estos valores en la sesión
  // falta que de alguna parte salgan el user_id y User_name que están hardcodeados arriba
  $_SESSION['user_name'] = $user_name;
  $_SESSION['password'] = $password;

  // Mandamos al usuario al inicio
  go_home();
} elseif ($request_method === 'GET') {
  // En este caso, que se trata de obtener la página de inicio de sesión
  // y no hay una sesión iniciada, se muestra el form

  include './templates/header.html'; ?>
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
              <input class="input" type="text" name="password">
            </div>
          </div>
          <button class="button is-primary" type="submit" name="login">Login</button>
        </form>
      </div>
    </div>
  </section>
<?php include './templates/footer.html';
} ?>

