<h3 style="margin-left: 2%">Bienvenido al panel de administracion de usuarios</h3>
<div class="container-fluid">
    <div class="row">
        <?php foreach ($datos as $row){ ?>
            <!-- Card -->
            <div class="usuariosAdmin card card-cascade col-lg-2 col-md-4 col-sm-6 col-xs-12">

                <!-- Card image -->
                <div class="view view-cascade gradient-card-header blue-gradient text-center">

                    <!-- Title -->
                    <h2 class="card-header-title mb-3 text-dark"><?php echo $row->usuario ?></h2>
                    <!-- Subtitle -->
                    <p class="card-header-subtitle mb-0 text-muted"><?php echo $row->email ?></p>

                </div>

                <!-- Card content -->
                <div class="card-body card-body-cascade text-center">

                    <!-- Text -->
                    <p class="card-text"><strong>Nº Viajes Publicados: </strong><?php echo $row->viaje ?></p>
                    <p class="card-text"><strong>Nº Viajes Reservados: </strong><?php echo $row->vreservados ?></p>
                    <hr>

                    <p class="card-text text-info"><strong>Último Acceso: </strong><?php echo $row->fecha_acceso ?></p>

                    <hr>

                    <!-- Icono Activar usuario para el login -->
                    <a class="px-2 fa-lg tw-ic" href="<?php echo $_SESSION['home']."admin/usuarios/activar/".$row->id ?>" title="Activar usuario"><i class="far fa-check-circle text-success"></i></a>
                    <!-- Icono Banear usuario -->
                    <a class="px-2 fa-lg li-ic"  href="<?php echo $_SESSION['home']."admin/usuarios/banear/".$row->id ?>" title="¿Estas seguro de banearlo?"><i class="fas fa-ban text-warning"></i></a>
                    <!-- Icono eliminar de la BBDD al usuario -->
                    <a class="px-2 fa-lg li-ic"  href="<?php echo $_SESSION['home']."admin/usuarios/elimUsuario/".$row->id ?>" title="¿Borrar cuenta?"><i class="fas fa-user-slash text-danger"></i></i></a>
                </div>

            </div>
        <?php } ?>
    </div>
</div>
