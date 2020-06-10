<body class="fondo1">
    <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-login">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <a href="#" class="active" id="login-form-link">Entrar</a>
                                </div>
                                <div class="col-xs-6">
                                    <a href="#" id="register-form-link">Registrarse</a>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form id="login-form" action="" method="POST" role="form" style="display: block;">
                                        <div class="form-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                                            <input type="text" name="email" id="username" tabindex="1" class="form-control" placeholder="Correo electronico" value="">
                                        </div>
                                        <div class="form-group">
                                            <span class="input-group-addon"><i class="fas fa-unlock" aria-hidden="true"></i></span>
                                            <input type="password" name="clave" id="password" tabindex="2" class="form-control" placeholder="Contraseña">
                                        </div>
                                        <div class="form-group text-center">
                                            <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                                            <label for="remember"> Recordarme en este equipo</label>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="acceder" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Login">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="text-center">
                                                        <a href="#" tabindex="5" class="forgot-password">¿Has olvidado la contraseña?</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form id="register-form" action="" method="POST" role="form" style="display: none;">
                                        <div class="form-group">
                                            <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                            <input type="text" name="usuario" id="username" tabindex="1" class="form-control" placeholder="Nombre" value="">
                                        </div>
                                        <div class="form-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                                            <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Correo electronico" value="">
                                        </div>
                                        <div class="form-group">
                                            <span class="input-group-addon"><i class="fas fa-unlock" aria-hidden="true"></i></span>
                                            <input type="password" name="clave" id="password" tabindex="2" class="form-control" placeholder="Contraseña">
                                        </div>
                                        <div class="form-group">
                                            <span class="input-group-addon"><i class="fas fa-unlock-alt" aria-hidden="true"></i> </span>
                                            <input type="password" name="confirm-clave" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirma la contraseña">
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <input type="submit" name="registrar" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Registrarse">
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
