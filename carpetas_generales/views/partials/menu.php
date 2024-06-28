<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .dropdown-menu {
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../../../framework/img-logo/logo.png" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" onclick="toggleMenu()" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../dashboard/dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="tareasDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-clipboard"></i> Tareas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="tareasDropdown">
                            <a class="dropdown-item" href="../bandeja_de_tareas/crear.php">Crear Tarea</a>                            
                            <a class="dropdown-item" href="../bandeja_de_tareas/en_progreso.php">En progreso</a>
                            <a class="dropdown-item" href="../bandeja_de_tareas/listar.php">Todas las Tareas</a>
                            <a class="dropdown-item" href="../bandeja_de_tareas/pendientes.php">Tareas Pendientes</a>
                            <a class="dropdown-item" href="../bandeja_de_tareas/completadas.php">Tareas Completadas</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="listas.php"><i class="fas fa-th-list"></i>LT</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ot.php"><i class="fas fa-th"></i>OT</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="subidas.php"><i class="fa-solid fa-upload"></i>Subidas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="perfil.php"><i class="fas fa-user"></i>
                            <?php echo $_SESSION['nombre_usuario'] ?? 'Invitado'; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../classes/Login/Logout.php"><i class="fa-solid fa-person-walking-arrow-right"></i>
                            Salir
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

    <script>
        function toggleMenu() {
            const navbarNav = document.getElementById('navbarNav');
            if (navbarNav.classList.contains('show')) {
                navbarNav.classList.remove('show');
                setTimeout(() => {
                    navbarNav.style.height = '0px';
                }, 10);
            } else {
                navbarNav.classList.add('show');
                navbarNav.style.height = 'auto';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var dropdown = document.getElementById('tareasDropdown');
            var dropdownMenu = dropdown.nextElementSibling;

            dropdown.addEventListener('click', function(event) {
                event.preventDefault();
                dropdownMenu.classList.toggle('show');
            });

            // Cerrar el menú si se hace clic fuera de él
            window.addEventListener('click', function(event) {
                if (!dropdown.contains(event.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
        });
    </script>

