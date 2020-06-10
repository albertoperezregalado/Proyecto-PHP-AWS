<div class="text-center">
    <img src="https://i.pinimg.com/originals/2f/76/10/2f761052b71daf3331c25d0ef1e9765b.png" class="rounded mx-auto d-block imagenperf" alt="...">
    <h2><?php echo $_SESSION["usuario"] ?></h2>
    <h4><?php echo $_SESSION["email_usuario"] ?></h4>
    <br>
    <ul class="datoss list-inline">
        <li class="datosLi">
            <span><?php echo $_SESSION["num_viajes_usuario"] ?></span>
                Viajes Publicados
        </li>
        <li class="datosLi">
            <span><?php echo $_SESSION["num_viajes_usuario_reservados"] ?></span>
            Viajes Reservados
        </li>
    </ul>
</div>
<br>
<div class="container">
    <div class="row">
        <?php foreach ($datos as $row){ ?>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-sm-6 col-md-8">
                            <h4>Viaje Publicado</h4>
                            <strong>Universidad de destino</strong> <?php echo $row->uni ?> <i class="glyphicon glyphicon-home"></i>
                            <p>
                                <strong>Lugar de encuentro</strong> <?php echo $row->lugarQuedada ?> <i class="glyphicon glyphicon-flag"></i>
                                <br />
                                <strong>Nº Plazas Disponibles</strong> <?php echo $row->plazasDisponibles ?> <i class="glyphicon glyphicon-globe"></i>
                                <br />
                                <strong>Precio</strong> <?php echo $row->precio ?> €</p>
                            <!-- Split button -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary">
                                    <strong>Acciones</strong></button>
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Modificar</a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo $_SESSION['home']."admin/viajes/borrar/".$row->id_viaje ?>" title="¿Estas seguro de eliminarlo?">Eliminar</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>