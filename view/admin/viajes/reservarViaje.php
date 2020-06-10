<div class="container">

    <div id="ventanaReserva" style=" margin-top:1%" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info reserva">
            <div class="panel-heading reserva">
                <div class="panel-title">Reservar el viaje selecionado</div>
                <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="link" href="#">Ayuda</a></div>
            </div>
            <div class="panel-body" >
                <form>
                    <input type='hidden'  value='' />
                    <form id="reservar-form" class="form-horizontal" method="POST" >
                        <?php foreach ($datos as $row){ ?>
                            <div class="form-group">
                                <label for=" "  class="control-label col-md-5"> Viaje publicado por:  </label>
                                <div class="controls col-md-7 "  style="margin-bottom: 10px">
                                    <?php echo $row->nombreUserViaje ?>
                                    <span class="fas fa-user-circle"></span>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for=" "  class="control-label col-md-5"> Universidad de destino:  </label>
                                <div class="controls col-md-7 "  style="margin-bottom: 10px">
                                    <?php echo $row->uni ?>
                                    <span class="fas fa-university"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for=" "  class="control-label col-md-5"> Lugar de encuentro:  </label>
                                <div class="controls col-md-7 "  style="margin-bottom: 10px">
                                    <?php echo $row->lugarQuedada ?>
                                    <span class="glyphicon glyphicon-flag"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for=" "  class="control-label col-md-5"> Hora de ida:  </label>
                                <div class="controls col-md-7 " style="margin-bottom: 10px">
                                    <?php echo $row->hora_ir ?>
                                    <span class="far fa-clock"></span>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for=" "  class="control-label col-md-5"> Hora de vuelta:  </label>
                                <div class="controls col-md-7 " style="margin-bottom: 10px">
                                    <?php echo $row->hora_volver ?>
                                    <span class="fas fa-clock"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for=" "  class="control-label col-md-5"> Precio al mes:  </label>
                                <div class="controls col-md-7 " style="margin-bottom: 10px">
                                    <?php echo $row->precio ?>
                                    <span class="fas fa-euro-sign"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for=" "  class="control-label col-md-5"> Plazas diponibles:  </label>
                                <div class="controls col-md-7" style="margin-bottom: 10px">
                                    <?php echo $row->plazasDisponibles ?>
                                    <span class="fas fa-users"></span>
                                </div>
                            </div>
                            <div id="div_mensaje" class="form-group">
                                <label for="id_mensaje" class="control-label col-md-5"> Mensaje<span class="text-danger">*</span> </label>
                                <textarea class="form-control col-md-offset-1 col-md-10" id="exampleFormControlTextarea1" rows="3" name="textoMensaje"></textarea>
                            </div>

                            <div class="form-group">
                                <div class="controls col-md-offset-1 col-md-11 ">
                                    <div id="div_id_terms" class="checkbox required">
                                        <label for="id_terms" class=" requiredField">
                                            <input class="input-ms checkboxinput" id="id_terms" name="terms" style="margin-bottom: 10px" type="checkbox" required/>
                                            Acepto las <a href="#">condiciones de uso</a> y <a href="#">politica de privacidad</a><span class="text-danger"> *</span>
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
<!--                                separacion izq-->
                                <div class="aab controls col-md-3 "></div>
<!--                                ancho-->
                                <div class="controls col-md-6 ">
<!--                                    <input type="submit" name="reservar" id="reservar-submit" tabindex="4" class="form-control btn btn-reservar" value="Reservar">-->
                                    <a>
                                        <button class="btn" type="submit" name="reservar" id="reservar-submit" value="reservar">
                                            <i class="far fa-envelope"></i> Reservar
                                        </button>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </form>
                </form>
            </div>
        </div>
    </div>
</div>
