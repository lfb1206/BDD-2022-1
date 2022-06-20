<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles/mystyles.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
        <title> Plataforma de gestión comercial de vuelos </title>
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
                    <a class="button is-info is-rounded is-outlined is-right" href="crear_usuarios.php">
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
                                <a href="sesion_admin.php" class="title is-5 has-text-info is-active">
                                    <div align="center"  class="title is-5 has-text-info is-active">Sesión admin</div>
                                </a>
                            <?php } elseif ($_SESSION['tipo'] == "aerolinea") { ?>
                                <a href="sesion_aerolineas.php" class="title is-5 has-text-info is-active">
                                    <div align="center"  class="title is-5 has-text-info is-active">Sesion aerolineas</div>
                                </a>
                            <?php } elseif ($_SESSION['tipo'] == "pasajero") { ?>
                                <a href="pasajeros.php" class="title is-5 has-text-info is-active">
                                    <div align="center"  class="title is-5 has-text-info is-active">Pasajeros</div>
                                </a>
                        <?php } ?>
                        <?php } else { ?>
                            <a href="sesion_admin.php" class="title is-5 has-text-info is-active">
                                <div align="center"  class="title is-5 has-text-info is-active">Sesión admin</div>
                            </a>
                            <br/>
                            <a href="sesion_aerolineas.php" class="title is-5 has-text-info is-active">
                                <div align="center"  class="title is-5 has-text-info is-active">Sesion aerolineas</div>
                            </a>
                            <br/>
                            <a href="pasajeros.php" class="title is-5 has-text-info is-active">
                                <div align="center"  class="title is-5 has-text-info is-active">Pasajeros</div>
                            </a>
                        <?php } ?>
                        
                        <hr class="dropdown-divider" style = "background-color: hsl(0, 0%, 4%);">
                        <?php if (isset($_SESSION['username'])) { ?>
                            <br/>
                            <a href="logout.php" class="title is-5 has-text-info is-active">
                                <div align="center"  class="title is-5 has-text-info is-active">Cerrar Sesión</div>
                            </a>
                        <?php } else { ?>
                            <a href="login.php" class="title is-5 has-text-info is-active">
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
    