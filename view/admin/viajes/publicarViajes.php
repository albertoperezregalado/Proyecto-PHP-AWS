<section class="section pb-5 sectionPublicar">
    <h2 class="section-heading h1 pt-4">Publica tu viaje Fácil y Rápido</h2>
    <p class="section-description pb-4">Es preciso que rellenes todos los campos antes de publicar tu viaje
    para que la persona que le interese lo tenga mas claro posible.</p>

    <div class="row">
        <div class="col-lg-5 mb-4">

            <div class="card">

                <div class="card-body">
                    <form id="login-form" action="" method="POST" role="form" style="display: block;">
                        <!--Body-->
                        <div class="md-form">
                            <span class="glyphicon glyphicon-home"></span>
                            <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="universidad">
                                <option selected value="defect">Seleciona el campus de la universidad</option>
                                <option value="ISEP CEU">ISEP CEU</option>
                                <option value="Campus Moncloa">Campus Moncloa</option>
                                <option value="Campus Monteprincipe">Campus Monteprincipe</option>
                            </select>
                            <label for="form-Subject">Universidad de destino</label>
                        </div>
                        <br>
                        <div class="md-form">
                            <span class="glyphicon glyphicon-flag"></span>
                            <input type="text" name="lquedada" id="lugar_quedada" class="form-control">
                            <label for="form-name">Lugar de encuentro</label>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col">
                                <input type="text" name="horair" id="hora_ir" class="form-control" placeholder="Hora de ir">
                            </div>
                            <span class="glyphicon glyphicon-time"></span>
                            <div class="col">
                                <input type="text" name="horavolver" id="hora_volver" class="form-control" placeholder="Hora de volver">
                            </div>
                        </div>
                        <p class="text-center font-italic"><strong>*Recomendación:</strong> Para más claridad poner la hora en formato 24h y 00:00</p>
                        <br>

                        <div class="md-form col-md-12">
    <!--                        <span class="glyphicon glyphicon-plus"></span>-->
                            <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="plazas">
                                <option selected value="defect">Plazas disponibles</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                            <label for="form-Subject">Nº Plazas</label>
                            <br>
                            <br>
                            <div class="input-group clockpicker">
                                <input type="text" name="dinero" id="money" class="form-control" placeholder="Precio">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-euro"></span>
                                </span>
                            </div>
                            <label for="form-Subject">Importe del viaje al mes</label>
                        </div>

                        <br>
                        <div class="text-center mt-4">

                            <input type="submit" name="publicar" id="publicar-submit" tabindex="4" class="form-control btnPublicar" value="Publicar">
                            <span class="glyphicon glyphicon-share-alt"></span>

                        </div>
                    </form>
                </div>

            </div>

        </div>

        <div class="col-lg-7">
            <div class="row text-center">
                <div class="col-md-4">
                    <p> </p>
                </div>
                <div class="col-md-4">
                    <a class="btn-floating blue accent-1"><i class="fas fa-map-marker-alt"></i></a>
                    <p>Comprueba la localización que has puesto</p>
                </div>
            </div>
            <div id="map-container-google-11" class="z-depth-1-half map-container-6" style="height: 400px">
                <iframe src="https://maps.google.com/maps?q=madrid&t=&z=15&ie=UTF8&iwloc=&output=embed"
                        frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>

            <br>
        </div>

    </div>

</section>
