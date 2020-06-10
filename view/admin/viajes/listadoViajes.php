<form method="POST">
    <div style="display:flex; flex-direction: row; justify-content: left; align-items: center">
        <input type="submit" name="ordenarasc" id="ordenar-submit" tabindex="4" class="form-control btnOrdenar" value="Viajes más económicos">
    </div>
</form>
<br>

<div class="container-fluid">
    <div class="row">
        <?php foreach ($datos as $row){ ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="tile">
                    <div class="wrapper">
                        <div class="header">Viaje de <?php echo $row->nombreUserViaje ?></div>

                        <div class="dates">
                            <div class="start">
                                <strong>Hora Ida</strong> <?php echo $row->hora_ir ?>
                                <span></span>
                            </div>
                            <div class="ends">
                                <strong>Hora Vuelta</strong> <?php echo $row->hora_volver ?>
                            </div>
                        </div>

                        <div class="stats">
                            <div>
                                <strong>Universidad de destino</strong> <?php echo $row->uni ?>
                            </div>

                            <div>
                                <strong>Lugar de encuentro</strong> <?php echo $row->lugarQuedada ?>
                            </div>
                        </div>
                        <div class="stats">
                            <div>
                                <strong>Nº Plazas Disponibles</strong> <?php echo $row->plazasDisponibles ?>
                            </div>

                            <div>
                                <strong>Precio</strong> <?php echo $row->precio ?> €
                            </div>
                        </div>
                        <div class="footer">
                            <a href="<?php echo $_SESSION['home']."admin/viajes/reservarViaje/".$row->id_viaje ?>" class="btnMeInteresa">Me interesa</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>