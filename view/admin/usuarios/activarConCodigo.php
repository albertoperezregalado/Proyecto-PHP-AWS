<body class="fondo1">
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4><strong>Verifica tu cuenta</strong></h4>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="login-form" action="" method="POST" role="form" style="display: block;">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <p class="text-secondary">Introduce el codigo que te hemos enviado al email para confirmar el email</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span class="input-group-addon"><i class="fas fa-at" aria-hidden="true"></i></span>
                                    <input type="text" name="emailValid" id="emailval" tabindex="1" class="form-control" placeholder="Correo electronico" value="">
                                </div>
                                <div class="form-group">
                                    <span class="input-group-addon"><i class="fas fa-key" aria-hidden="true"></i></span>
                                    <input type="text" name="tokenValid" id="tokenval" tabindex="2" class="form-control" placeholder="TOKEN">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <p class="text-info">Si no te llega nada revisa la carpeta de SPAM del email</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="activarCuenta" id="activar-submit" tabindex="4" class="form-control btn btn-login" value="Activar">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

