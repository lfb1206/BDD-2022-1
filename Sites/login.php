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
//prepare the statement
// DESCOMENTAR 
$stmt = $db->prepare("SELECT * FROM usuarios WHERE username=? AND contrasena=?;");
$stmt->execute([$user_name, $password]); 
//fetch result
$user = $stmt->fetch();
if ($user) { print("El usuario existe :)");
    // username already exists
} else {print("El usuario no existe :(");
    // username does not exist
} 

//  $select = mysqli_query($conn, "SELECT * FROM usuarios WHERE username = '".$_POST['username']."'");
  //$select = mysqli_query($conn, "SELECT * FROM usuarios WHERE username = 'DGAC'");
  //if(mysqli_num_rows($select)> 0) { 
    //$holahola = "ya existe :)";
    //exit('This username already exists')
  //} else { 
    //$holahola = "no existe :(";
  //}

    // Se guardan estos valores en la sesión
    // falta que de alguna parte salgan el user_id y User_name que están hardcodeados arriba
  $_SESSION['user_name'] = $user_name;
  $_SESSION['password'] = $password;
  $_SESSION['holahola'] = $holahola;
  $_SESSION['tipo'] = "dgac";
  // Mandamos al usuario al inicio
  go_home();
} elseif ($request_method === 'GET') {
  // En este caso, que se trata de obtener la página de inicio de sesión
  // y no hay una sesión iniciada, se muestra el form

  include './templates/header.php'; ?>
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
      </div>
    </div>
  </section>
<?php include './templates/footer.php';
} ?>

