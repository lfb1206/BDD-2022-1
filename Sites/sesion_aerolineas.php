<?php
include 'templates/header.php';

// Vemos si se esta mandando el form o se está recibiendo
$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
if ($request_method  === 'POST') {
  $query = "
  INSERT INTO propuesta_vuelo (codigo, fecha_salida, fecha_llegada, fecha_envio_propuesta, aeronave_codigo, id_aerodromo_salida, id_aerodromo_llegada, estado, compagnia_codigo, realizado)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
  ";
  $q = $db2 -> prepare($query);
  $q -> execute([
    $_POST['codigo_vuelo'],
    $_POST['fecha_salida'],
    $_POST['fecha_llegada'],
    date("Y-m-d"), # fecha_envio_propuesta
    $_POST['aeronave_codigo'],
    $_POST['aerodromo_salida'],
    $_POST['aerodromo_llegada'],
    $_POST['estado'],
    $_SESSION['username'], # compagnia_codigo
    $_POST['realizado'],
  ]);
  $propuesta = $q->fetch();
  
  go_home();
  ?>
<?php
}
$query = "
  SELECT aerodromo_id, nombre
  FROM Aerodromo
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
    <div class="column is-4" align="center">
      <!-- https://bulma.io/documentation/form/general/ -->
      <form method="post">
        <div class="field">
          <label class="label">Codigo vuelo</label>
          <div class="control">
            <input class="input" type="text" name="codigo_vuelo">
          </div>
        </div>
        <div class="field">
          <label class="label">Fecha salida</label>
          <div class="control">
            <input class="input" type="date" name="fecha_salida">
          </div>
        </div>
        <div class="field">
          <label class="label">Fecha llegada</label>
          <div class="control">
            <input class="input" type="date" name="fecha_llegada">
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
            <select name="aerodromo_salida" id="ar" style="border-radius: 10px; height: 48px;">
              <?php
              foreach ($result as $data) {
                  echo "<option value=\"$data[0]\">$data[1]</option>";
              }
              ?>
            </select>
          </div>
        </div>
        <div class="field">
          <label class="label">Aerodromo llegada</label>
          <div class="control">
            <select name="aerodromo_llegada" id="ar" style="border-radius: 10px; height: 48px;">
              <?php
              foreach ($result as $data) {
                  echo "<option value=\"$data[0]\">$data[1]</option>";
              }
              ?>
            </select>
          </div>
        </div>

        <input type="hidden" name="estado" value="pendiente">

        <input type="hidden" name="realizado" value="no realizado">
        
        <button class="button is-info" type="submit" name="Crear propuesta">Crear propuesta</button>
      </form>
    </div>
  </div>
</section>

<a class="button is-info" href="sesion_aerolineas_aceptado.php">Vuelos aceptados</a>
<a class="button is-info" href="sesion_aerolineas_rechazado.php">Vuelos rechazado</a>

</br>
</br>
</br>

<?php include('templates/footer.php'); ?>
