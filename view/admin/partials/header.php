<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>CEUcar</title>

    <!--    icono-->
    <link rel="icon" href="http://35.180.254.5/aaaProyectoFinalCEUcar/public/img/icono.png">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo $_SESSION['public'] ?>css/admin.css">
<!---->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body>

<?php if (isset($_SESSION['usuario'])){ ?>
    <nav class="menu navbar-icon-top navbar-expand-lg navbar-dark bg-dark fixed-top navbar-static-top">
        <a class="navbar-brand" href="#"><img class="logoImagen" src="http://35.180.254.5/aaaProyectoFinalCEUcar/public/img/LogoCeuCar.png"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo $_SESSION['home'] ?>admin" title="Inicio">
                        <i class="fa fa-home"></i>
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $_SESSION['home'] ?>admin/viajes/publicarViajes" title="Publicar Viaje">
                        <i class="fa fa-edit"></i>
                    </a>
                </li>
<!--                --><?php //if ($_SESSION['viaje'] == 1){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $_SESSION['home'] ?>admin/viajes/listadoViajes" title="Listado de Viajes">
                            <i class="fa fa-tasks"></i>
                        </a>
                    </li>
<!--                --><?php //} ?>
<!--                mirar el 0 y 1 de viajes reservados me desaparece cuando pongo 1-->
                <?php if ( isset($_SESSION['num_viajes_usuario_reservados']) and $_SESSION['num_viajes_usuario_reservados'] > 0){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $_SESSION['home'] ?>admin/viajes/viajesReservados" title="Viajes Reservados">
                            <i class="fa fa-car"></i>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($_SESSION['usuarios'] == 1){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-envelope-o">
                        </i>
                        Menu Admin
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?php echo $_SESSION['home'] ?>admin/usuarios" title="Usuarios">Listado Usuarios</a>
                        <a class="dropdown-item" href="#">---</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">---</a>
                    </div>
                </li>
                <?php } ?>
            </ul>
            <ul class="navbar-nav navbar-right">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $_SESSION['home'] ?>admin/usuarios/miPerfil" title="Mi Perfil">
                        <i class="fa fa-user derecha">
                        </i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $_SESSION['home'] ?>admin/usuarios/chats" title="Mi Chat">
                        <i class="fas fa-comments fa-2x derecha">
                        </i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" title="Notificaciones">
                        <i class="fa fa-bell derecha">
                            <span class="badge badge-danger">11</span>
                        </i>
                    </a>
                </li>
                <li class="nav-item float-xl-left">
                    <a class="nav-link" href="<?php echo $_SESSION['home'] ?>admin/salir" title="Salir">
                        <i class="fa fa-power-off derecha">
                        </i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>


<?php } ?>

<!-- Si existen mensajes  -->
<?php if (isset($_SESSION["mensaje"])) { ?>

    <div class="alert <?php echo $_SESSION["mensaje"]['tipo'] ?> alert-dismissible fade in" role="alert">
        <button type="button" class="close" click.delegate="dismiss" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Hey!</strong> <?php echo $_SESSION["mensaje"]['texto'] ?>
    </div>

    <!-- Borro mensajes -->
    <?php unset($_SESSION["mensaje"]) ?>

<?php } ?>


<!--<main>-->
<!---->
<!--    <header>-->
<!--        <h1>Panel de administración</h1>-->
<!---->
<!--        --><?php //if (isset($_SESSION['usuario'])){ ?>
<!---->
<!--            <h2>-->
<!--                Usuario: <strong>--><?php //echo $_SESSION['usuario'] ?><!--</strong>-->
<!--            </h2>-->
<!---->
<!--        --><?php //} else { ?>
<!---->
<!--            <h2>Bienvenido, introduce usuario y contraseña.</h2>-->
<!---->
<!--        --><?php //} ?>
<!--    </header>-->
<!---->
<!--    <section class="container-fluid">-->
