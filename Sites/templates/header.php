<?php

// Este archivo se puede importar en cada archivo .php, y se puede tener
// aquí todo lo necesario para no tener que agregarlo para cada archivo.
// No tiene nada de mágico, es un archivo php cualquiera con un nombre arbitrario.

// Cargamos los datos para poder iniciar la BDD
require_once __DIR__ . "/../log/config/data.php";

// Se conecta a la BDD
require_once __DIR__ . "/../log/config/conexion.php";

// Se crea siempre una sesión
session_start();


// Funciones propias de utilidad

/**
 * Volver al inicio, tiene que se llamada antes de entregar HTML.
 */
function go_home() {
  header("Location: " . '/~grupo19/');
  exit();
}

/**
 * Ejemplo de componentes, donde uno llama a la función y se genera HTML
 * NOTA: Aunque esto esta funcional, el nombre de las columnas es el mismo
 *       que en la BDD, se podria modificar para poder elegir que nombre mostrar.
 *       [[Ver PDOStatement::fetch](https://www.php.net/manual/es/pdostatement.fetch.php)]
 *
 * @param PDOStatement $query
*/
function table_from_query($query) { ?>
  <div class="table-container">
    <table class="table">
      <thead>
        <tr>
          <!-- Por cada columna, muestra el nombre -->
          <?php foreach (range(0, $query->columnCount() - 1) as $col_index) { ?>
            <th><?php echo htmlentities($query->getColumnMeta($col_index)['name']) ?></th>
          <?php } ?>
        </tr>
      </thead>
      <tbody>
        <!-- Mostrar una celda por cada valor de cada resultado -->
        <!-- hmtlentities se utiliza para evitar XXS, vulnerabilidad que no se pasa en este ramo -->
        <!-- https://es.wikipedia.org/wiki/Cross-site_scripting => insertar código HTML peligroso en sitios que lo permitan -->
        <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>
          <tr>
            <?php foreach ($row as $value) { ?>
              <th><?php echo htmlentities($value) ?></th>
            <?php } ?>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
<?php
}
?>

<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
        <link rel="stylesheet" href="./styles/mystyles.css">
        <title> Plataforma de gestión comercial de vuelos </title>
        <link rel="icon" href="https://icon-library.com/images/airplane-icon/airplane-icon-29.jpg">
    </head>

    <body>
        <nav class="navbar is-black" role="navigation" aria-label="dropdown navigation">
            <div class="navbar-brand">
                <a class="navbar-item" style = "position:relative; left:20px; top:0.001px;" href="https://www.google.com/logos/2010/pacman10-i.html">
                    <ion-icon size="large" name="airplane-outline"></ion-icon>
                </a>
            </div>

            <div style="border: 5px; width: 450px; padding: 10px; text-align: center; margin: 5px; text-align: center; color: #198BB9";>
                <div class="title is-3 has-text-info">Gestión comercial de vuelos</div>
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <a class="button is-info is-rounded is-outlined is-right" href="log/crear_usuarios.php">
                            Importar usuarios
                        </a>
                    </div>
                </div>
                <div class="navbar-item has-dropdown is-hoverable is-black" style = "background-color: hsl(0, 0%, 4%);">
                    <a href="index.php">
                        <div style="border: 5px; width: 150px; padding: 10px;";>
                            <h4 class="title is-3 has-text-info">Menú</h4>
                        </div>
                    </a>

                    <div class="navbar-dropdown is-center is-boxed" style = "background-color: hsl(0, 0%, 4%);">
                        <div class="dropdown-content" style = "background-color: hsl(0, 0%, 4%);">
                            <?php if (isset($_SESSION['username'])) { ?>
                                <?php if ($_SESSION['tipo'] == "dgac") { ?>
                                    <a href="admin/sesion_admin.php" class="title is-5 has-text-info is-active">
                                        <div align="center"  class="title is-5 has-text-info is-active">Gestionar vuelos</div>
                                    </a>
                                <?php } elseif ($_SESSION['tipo'] == "aerolinea") { ?>
                                    <a href="aerolinea/sesion_aerolineas.php" class="title is-5 has-text-info is-active">
                                        <div align="center"  class="title is-5 has-text-info is-active">Proponer vuelo</div>
                                    </a>
                                    <br/>
                                    <a href="aerolinea/sesion_aerolineas_aceptado.php" class="title is-5 has-text-info is-active">
                                        <div align="center"  class="title is-5 has-text-info is-active">Vuelos aceptados</div>
                                    </a>
                                    <br/>
                                    <a href="aerolinea/sesion_aerolineas_rechazado.php" class="title is-5 has-text-info is-active">
                                        <div align="center"  class="title is-5 has-text-info is-active">Vuelos rechazado</div>
                                    </a>
                                <?php } elseif ($_SESSION['tipo'] == "pasajero") { ?>
                                    <a href="pasajero/sesion_pasajeros.php" class="title is-5 has-text-info is-active">
                                        <div align="center"  class="title is-5 has-text-info is-active">Reservar</div>
                                    </a>
                                    <br/>
                                    <a href="pasajero/datos_pasajero.php" class="title is-5 has-text-info is-active">
                                        <div align="center"  class="title is-5 has-text-info is-active">Datos</div>
                                    </a>
                                <?php } ?>
                            <?php } ?>
                            <hr class="dropdown-divider" style = "background-color: hsl(0, 0%, 4%);">
                            <?php if (isset($_SESSION['username'])) { ?>
                                <br/>
                                <a href="log/logout.php" class="title is-5 has-text-info is-active">
                                    <div align="center"  class="title is-5 has-text-info is-active">Cerrar Sesión</div>
                                </a>
                            <?php } else { ?>
                                <a href="log/login.php" class="title is-5 has-text-info is-active">
                                    <div align="center"  class="title is-5 has-text-info is-active">Iniciar sesión</div>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <br/>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    