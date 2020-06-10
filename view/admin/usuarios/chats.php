<body class="fondo10">
    <div class="container-fluid">
        <div class="row">
            <?php foreach ($datos as $row){ ?>
                <div class="col-lg-11 col-md-4 col-sm-6 col-xs-12 cardsChat">
                    <div class="tile chatsGenerales">
                        <div class="wrapper">
                            <img src="http://35.180.254.5/aaaProyectoFinalCEUcar/public/img/avatarBueno.png" alt="" class="imgchat">
<!--                            <img src="https://www.alliancerehabmed.com/wp-content/uploads/icon-avatar-default.png" alt="" class="imgchat">-->

                            <div class="card-body text-center textoChat">
                                <h5 class="card-title"><strong><?php echo $row->usuario ?></strong></h5>
                                <p class="card-text"><?php echo $row->email ?></p>
                            </div>
                            <!-- Icono Activar usuario para el login -->
<!--                            <a class="iconoChat" href="--><?php //echo $_SESSION['home']."admin/usuarios/chatUsuario"?><!--" title="Hablar con el usuario"><i class="far fa-comment-dots fa-3x text-primary"></i></a>-->
                            <a class="iconoChat" href="<?php echo $_SESSION['home']."admin/usuarios/chatUsuario/".$row->id ?>" title="Hablar con el usuario"><i class="far fa-comment-dots fa-3x text-primary"></i></a>


                            <div class="card-footer text-center footerChat">
                                <small class="text-muted">Ultima conexión</small>
                                <small class="text-danger"><?php echo $row->fecha_acceso ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>