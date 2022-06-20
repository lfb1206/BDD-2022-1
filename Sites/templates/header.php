<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
        <title> Plataforma de gestión comercial de vuelos </title>
        <link rel="stylesheet" href="styles/mystyles.css">
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
            <div class="navbar-item has-dropdown is-hoverable is-black">
                <div style="border: 5px; width: 150px; padding: 10px;";>
                    <h4 class="title is-3 has-text-info">Menú</h4>
                </div>

                <div class="navbar-dropdown is-center is-boxed">
                    <div class="dropdown-content">
                        <?php if (isset($_SESSION['user_name'])) { ?>
                            
                        <?php } if (isset($_SESSION['user_name'])) { ?>
                            
                        <?php } if (isset($_SESSION['user_name'])) { ?>
                            
                        <?php } else { ?>
                            
                        <?php } ?>
                        <hr class="dropdown-divider">
                        <?php if (isset($_SESSION['user_name'])) { ?>
                            <form class="buttons" action="logout.php">
                                <input class="button" type="submit" value="Cerrar Sesión">
                            </form>
                        <?php } else { ?>
                            <div class="buttons">
                                <a class="button is-primary" href="crear_usuarios.php">
                                    Importar usuarios
                                </a>
                                <a href="login.php" class="button is-light">
                                    Iniciar sesión
                                </a>
                            </div>
                        <?php } ?>
                    </div>
            </div>
            </div>
        </div>
        </nav>
        <br/>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    