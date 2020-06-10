<div class="container">
    <div class="row">
        <?php foreach ($datos as $row){ ?>
            <div class="col-xs-12" style="margin-top: 2%">
                <div class="box">
                    <div class="icon">
                        <div class="image pulso"><i class="glyphicon glyphicon-home"></i></div>
                        <div class="info caja text-center">
                            <p class="reservViaje" style="font-size: 20px">Viaje reservado</p>
                            <p><strong>Universidad de destino:</strong> <?php echo $row->uniReserv ?></p>
                            <p><strong>Hora quedada:</strong> <?php echo $row->horaIrReserv ?><strong> y lugar: </strong><?php echo $row->encuentroReserv ?></p>
                            <div class="card-footer text-muted text-center">
                                Precio al mes: <?php echo $row->precioReserv ?> €
                            </div>
                            </br>
                            <button type="button" class="btn btn-secondary"><a style="color:white; text-decoration: none;" href="<?php echo $_SESSION['home']."admin/viajes/borrarReserv/".$row->id_reserva ?>" title="¿Estas seguro de eliminarlo?"><strong>Eliminar reserva viaje</strong></a></button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>