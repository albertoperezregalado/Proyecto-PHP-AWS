<?php
namespace App\Controller;

//GESTIONA DENTRO DEL PANEL TODOLO RELATIVO A LOS USUARIOS COMO LA ENTRADA DE ELLOS, MODIFICARLOS,...


use App\Helper\ViewHelper;
use App\Helper\DbHelper;
use App\Model\Partida;
use App\Model\Usuario;
use App\Model\Viaje;
use App\Model\Chat;

//estos uses son para la verificacion de email
require '../phpmailer/plugins/PHPMailer/src/Exception.php';
require '../phpmailer/plugins/PHPMailer/src/PHPMailer.php';
require '../phpmailer/plugins/PHPMailer/src/SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class UsuarioController
{
    var $db;
    var $view;

    function __construct()
    {
        //Conexión a la BBDD
        $dbHelper = new DbHelper();
        $this->db = $dbHelper->db;

        //Instancio el ViewHelper
        $viewHelper = new ViewHelper();
        $this->view = $viewHelper;
    }

    public function admin(){

        //Compruebo permisos
        $this->view->permisos();

        //LLamo a la vista
        $this->view->vista("admin","index");

    }

    public function comprobar(){

        //$usuario = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_STRING);
        $campo_usuario = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_STRING);
        $campo_clave = filter_input(INPUT_POST, "contrasena", FILTER_SANITIZE_STRING);

        //Busco al usuario en la base de datos, con el LIMIT 1 es para que me de solo 1 resultado
        $rowset = $this->db->query("SELECT * FROM usuarios WHERE usuario='$campo_usuario' AND activo=1 LIMIT 1");

        //Asigno resultado a una instancia del modelo
        $row = $rowset->fetch(\PDO::FETCH_OBJ);
        $usuario = new Usuario($row);
        //Si existe el usuario
        if ($usuario->usuario){
            //Compruebo la clave al cifrarlo coinciden no que sean iguales
            if (password_verify($campo_clave,$usuario->clave)) {

                //Guardo la fecha de último acceso
                $ahora = new \DateTime("now", new \DateTimeZone("Europe/Madrid"));
                $fecha = $ahora->format("Y-m-d H:i:s");
                $this->db->exec("UPDATE usuarios SET fecha_acceso='$fecha' WHERE usuario='$campo_usuario'");

                echo "si";

            }
            else{
                //Redirección con mensaje
                echo "no";
            }
        }
        else{
            //Redirección con mensaje
            echo "no";
        }


    }

    public function entrar(){

        //Si ya está autenticado, le llevo a la página de inicio del panel
        if (isset($_SESSION['usuario'])){

            $this->admin();

        }
        else if (isset($_POST["registrar"])){
            $this->registrar();
        }
        else if (isset($_POST["activarCuenta"])){
            $this->activarConCodigo();
        }
        //Si ha pulsado el botón de acceder, tramito el formulario
        else if (isset($_POST["acceder"])){

            //Recupero los datos del formulario
            //$campo_usuario = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_STRING);
            $campo_email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $campo_clave = filter_input(INPUT_POST, "clave", FILTER_SANITIZE_STRING);

            //Busco al usuario en la base de datos, con el LIMIT 1 es para que me de solo 1 resultado
            //$rowset = $this->db->query("SELECT * FROM usuarios WHERE usuario='$campo_usuario' AND activo=1 LIMIT 1");

            $rowset = $this->db->query("SELECT * FROM usuarios WHERE email='$campo_email' AND activo=1 LIMIT 1");

            //Asigno resultado a una instancia del modelo
            $row = $rowset->fetch(\PDO::FETCH_OBJ);
            $usuario = new Usuario($row);

            //Si existe el usuario
            if ($usuario->usuario){
                //Compruebo la clave al cifrarlo coinciden no que sean iguales
                if (password_verify($campo_clave,$usuario->clave)) {

                    //Asigno el usuario y los permisos la sesión
                    $_SESSION["usuario"] = $usuario->usuario;
                    $_SESSION["id_usuario"] = $usuario->id;
                    $_SESSION["email_usuario"] = $usuario->email;
                    $_SESSION["usuarios"] = $usuario->usuarios;
                    $_SESSION["num_viajes_usuario"] = $usuario->viaje;
                    $_SESSION["num_viajes_usuario_reservados"] = $usuario->vreservados;

                    //Guardo la fecha de último acceso
                    $ahora = new \DateTime("now", new \DateTimeZone("Europe/Madrid"));
                    $fecha = $ahora->format("Y-m-d H:i:s");
                    $this->db->exec("UPDATE usuarios SET fecha_acceso='$fecha' WHERE email='$campo_email'");


                    //Redirección con mensaje
                    $this->view->redireccionConMensaje("admin","alert-success","Bienvenido " . $_SESSION["usuario"]);
                }
                else{
                    //Redirección con mensaje
                    //contraseña incorrecta
                    $this->view->redireccionConMensaje("admin","alert-danger","contraseña incorrecta");
                }
            }
            else{
                //Redirección con mensaje
                //no existe usuario registrado con ese correo
                $this->view->redireccionConMensaje("admin","alert-warning","Usuario no registrado o cuenta no activada");
            }
        }
        //Le llevo a la página de acceso
        else{
            $this->view->vista("admin","usuarios/entrar");
        }

    }

    public function salir(){

        //Borro al usuario de la sesión y todas las sesiones que hemos abierto al hacer el login antes
        unset($_SESSION['usuario']);
        unset($_SESSION['id_usuario']);
        unset($_SESSION["email_usuario"]);
        unset($_SESSION["num_viajes_usuario"]);
        unset($_SESSION["num_viajes_usuario_reservados"]);

        //Redirección con mensaje
        $this->view->redireccionConMensaje("admin","alert-success","Te has desconectado con éxito. ");

    }

    //Listado de usuarios
    public function index(){

        //Permisos
        $this->view->permisos("usuarios");

        //Recojo los usuarios de la base de datos
        $rowset = $this->db->query("SELECT * FROM usuarios ORDER BY usuario ASC");

        //Asigno resultados a un array de instancias del modelo
        $usuarios = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
            array_push($usuarios,new Usuario($row));
        }

        $this->view->vista("admin","usuarios/index", $usuarios);

    }



    public function crear(){

        //Permisos
        $this->view->permisos("usuarios");

        //Creo un nuevo usuario vacío
        $usuario = new Usuario();

        //Llamo a la ventana de edición
        $this->view->vista("admin","usuarios/editar", $usuario);

    }


    public function registrar(){

        //Recupero los datos del formulario
        $usuario = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_STRING);
        $clave = filter_input(INPUT_POST, "clave", FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);

        if($usuario == "" || $clave == ""){
            $this->view->redireccionConMensaje("admin","alert-danger","Comprueba que has rellenado los campos.");

        }else{
            //Encripto la clave
            $clave_encriptada =  password_hash($clave,  PASSWORD_BCRYPT, ['cost'=>12]);

            //Guardo la fecha de registro
            $ahora = new \DateTime("now", new \DateTimeZone("Europe/Madrid"));
            $fecha = $ahora->format("Y-m-d H:i:s");
            //$this->db->exec("UPDATE usuarios SET fecha_acceso='$fecha' WHERE usuario='$campo_usuario'");

            //Genero un token unico para el usuario para la previa confirmacion de email
            //generamos un string random
            $token = openssl_random_pseudo_bytes(8);
            //convertimos de binario a hexadecimal
            $tokenGenerado = bin2hex($token);
            //echo $tokenGenerado;


            //Creo un nuevo usuario ------------------------->
            //$this->db->exec("INSERT INTO usuarios (usuario, clave, email, fecha_acceso, token) VALUES ('$usuario','$clave_encriptada','$email','$fecha','$tokenGenerado')");

            //echo "registrado";
            //$this->view->redireccionConMensaje("admin","alert-success","Usuario registrado correctamente");


            //MODO PARA ENVIAR MENSAJE DE CONFIRMACION AL EMAIL
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
            $mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
            $mail->Port = 587; // TLS only
            $mail->SMTPSecure = 'tls'; // ssl is depracated
            $mail->SMTPAuth = true;

            $mail->Username   = 'jamproyects@gmail.com';                     // SMTP username
            $mail->Password   = 'Dana946.';                //CONTRASEÑA EMAIL PRINCIPAL

            $mail->setFrom('jamproyects@gmail.com', 'CEUcar');
            $mail->addAddress($email, $usuario);
            $mail->Subject = 'Activar cuenta CEUcar';
            $mail->msgHTML("
                            <html>
                                <body>
                                    <strong>Bienvenido a CEUcar</strong><br>
                                    Comprueba los siguientes datos introducidos y si estan bien activa tu cuenta:<br><br>
                                    ___________________________________________________________________<br><br>
                                    Usuario: '$usuario'<br>
                                    Email: '$email'<br>
                                    Pass: '$clave'<br>
                                    <br>
                                    Hora y dia de registro: '$fecha'<br>
                                    <br>
                                    Para activar la cuenta copie el token generado e introduzcalo en la ventana de activacion
                                    <br>
                                    -_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
                                    <h2>$tokenGenerado</h2>
                                    -_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_
                                    <br>
                                    <br>
                                    Este email es para el registro de la app CEUcar si ha recibido el mensaje si haber hecho ningun registro borre este, en caso contrario active su cuenta en el enlace<br>
                                    <br>
                                    Gracias,<br><br>
                                    <strong>CEUcar</strong><br>
                                    ____________________________________________________________________<br>
                                    <br>
                                    App creada por Alberto Perez Regalado<br>
                                    <a href='#'>Email</a><br>
                                    <a href='#'>Web</a><br>
                                 </body>  
                             </html>                                
                           ");
            $mail->AltBody = 'Hubo un problema para visualizar el email';
            // $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file

            if(!$mail->send()){
                //echo "Mailer Error: " . $mail->ErrorInfo;
                $this->view->redireccionConMensaje("admin","alert-danger","Hubo un error inesperado");

            }else{
                //echo "Message sent!";
                $this->db->exec("INSERT INTO usuarios (usuario, clave, email, fecha_acceso, token) VALUES ('$usuario','$clave_encriptada','$email','$fecha','$tokenGenerado')");
                //$this->view->redireccionConMensaje("admin/usuarios/activarConCodigo/","alert-success","Email de confirmacion enviado");
                $this->view->vista("admin","usuarios/activarConCodigo");
            }
        }



        //Mensaje y redirección
        //$this->view->redireccionConMensaje("admin/usuarios","green","El usuario <strong>$usuario</strong> se registro correctamente.");

    }

    public function miPerfil(){
        //echo $_SESSION["num_viajes_usuario_reservados"];
        $usuarioActivo = $_SESSION['usuario'];
        //Consulta a la bbdd solo los viajes del usuario
        $rowset = $this->db->query("SELECT * FROM viaje WHERE  nombreUserViaje='$usuarioActivo' ORDER BY id_viaje DESC");

        //Asigno resultados a un array de instancias del modelo
        $viaje = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
            array_push($viaje,new Viaje($row));
        }

        $this->view->vista("admin", "usuarios/miPerfil", $viaje);
    }

    //Para activar o desactivar
    public function activar($id){

        //Permisos
        $this->view->permisos("usuarios");

        //Borro el usuario
        $consulta = $this->db->exec("UPDATE usuarios SET activo=1 WHERE id='$id'");

        //Mensaje y redirección
        ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
            $this->view->redireccionConMensaje("admin/usuarios","alert-success","El usuario activado correctamente") :
            $this->view->redireccionConMensaje("admin/usuarios","alert-danger","El usuario ya estaba activado");


    }

    public function banear($id){

        //Permisos
        $this->view->permisos("usuarios");

        //Borro el usuario
        $consulta = $this->db->exec("UPDATE usuarios SET activo=0 WHERE id='$id'");

        //Mensaje y redirección
        ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
            $this->view->redireccionConMensaje("admin/usuarios","alert-success","El usuario se ha baneado correctamente") :
            $this->view->redireccionConMensaje("admin/usuarios","alert-danger","El usuario ya estaba baneado");

    }

    public function elimUsuario($id){

        //Permisos
        $this->view->permisos("usuarios");

        //Borro el usuario
        $consulta = $this->db->exec("DELETE FROM usuarios WHERE id='$id'");

        //Mensaje y redirección
        ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
            $this->view->redireccionConMensaje("admin/usuarios","alert-success","El usuario se ha borrado permanentemente") :
            $this->view->redireccionConMensaje("admin/usuarios","alert-danger","No se a podido eliminar al usuario");

    }

    //funcion que sirve cuando el usuario mete el email y el token para activar la cuenta
    public function activarConCodigo(){
        //si pulsa al boton de activar

            //Recupero los datos del formulario
            $emailValid = filter_input(INPUT_POST, "emailValid", FILTER_SANITIZE_EMAIL);
            $tokenValid = filter_input(INPUT_POST, "tokenValid", FILTER_SANITIZE_STRING);


            //Busco al usuario en la base de datos, con el LIMIT 1 es para que me de solo 1 resultado

            $consultaValidar = $this->db->query("SELECT * FROM usuarios WHERE email='$emailValid' AND token='$tokenValid'");
            //esto es para saber si me devuelve un valor
            $row = $consultaValidar ->fetch(\PDO::FETCH_OBJ);
            //si ha encontrado la columna con el email hace esto si no el else
            if ($row->email) {
                    //hago en UPDATE DE ACTIVO A 1 EL USUARIO
                    $this->db->exec("UPDATE usuarios SET activo=1 WHERE email='$emailValid' AND token='$tokenValid'");

                //MODO PARA ENVIAR MENSAJE DE CONFIRMACION AL EMAIL
                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
                $mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
                $mail->Port = 587; // TLS only
                $mail->SMTPSecure = 'tls'; // ssl is depracated
                $mail->SMTPAuth = true;

                $mail->Username   = 'jamproyects@gmail.com';                     // SMTP username
                $mail->Password   = 'Dana946.';                //CONTRASEÑA EMAIL PRINCIPAL

                $mail->setFrom('jamproyects@gmail.com', 'CEUcar');
                $mail->addAddress($emailValid, 'nuevo usuario');
                $mail->Subject = 'Cuenta en CEUcar activada!';
                $mail->msgHTML("
                            <html>
                                <body>
                                    <strong>HOLA!</strong><br>
                                    <br>
                                    Felicidades tu cuenta en CEUcar ha sido activada correctamente, ya puedes empezar a utilizar el servicio<br><br>
                                    ___________________________________________________________________<br><br>
                                    <br>
                                    <br>
                                    Este email es para el registro de la app CEUcar si ha recibido el mensaje si haber hecho ningun registro borre este, en caso contrario no hace falta realizar ninguna accion<br>
                                    <br>
                                    Gracias,<br><br>
                                    <strong>CEUcar</strong><br>
                                    ____________________________________________________________________<br>
                                    <br>
                                    App creada por Alberto Perez Regalado<br>
                                    <a href='#'>Email</a><br>
                                    <a href='#'>Web</a><br>
                                 </body>  
                             </html>                                
                           ");
                $mail->AltBody = 'Hubo un problema para visualizar el email';
                // $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file

                    if(!$mail->send()){
                        //echo "Mailer Error: " . $mail->ErrorInfo;
                        $this->view->redireccionConMensaje("admin","alert-danger","Hubo un error inesperado");

                    }else{
                        //echo "Message sent!";
                        $this->view->redireccionConMensaje("admin", "alert-success", "¡Cuenta activada correctamente!");
                    }




                } else {
                    echo "error";
                    //en caso de que no encuentre 1 resultado volvera a estar en la misma ventana
                    $this->view->vista("admin", "usuarios/activarConCodigo");
                }

    }


    //funcion que te lleva a la ventana de ayuda
    public function chats(){
        $IdUserLogueado =  $_SESSION['id_usuario'];
        //que me saque la lista de todos los usuarios excepto el que esta logueado, es decir de ti mismo
        $rowset = $this->db->query("SELECT * FROM usuarios WHERE id <> '$IdUserLogueado' ORDER BY id ASC");

        //Asigno resultados a un array de instancias del modelo
        $usuarios = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)) {
            array_push($usuarios, new Usuario($row));
        }

        //echo "llego";
        //Llamo a la vista
        //$this->view->vista("admin", "noticias/index", $partida);
        //Llamo a la vista
        $this->view->vista("admin", "usuarios/chats", $usuarios);
    }

    public function chatUsuarioPrivado($id){
        //header("refresh: 3");
        //recupero el id y nombre del usuario que esta logueando y esta escribiendo
        $deId =  $_SESSION['id_usuario'];
        $deNombre = $_SESSION["usuario"];


        //recupero la lista de mensajes y los muestro solo los que coincidan con el id del que e pinchado y con el que esta registrado en la web
        $rowset = $this->db->query("SELECT * FROM chat WHERE deId='$deId' AND aId='$id' OR deId='$id' AND aId='$deId' ORDER BY creado ASC");

        //Asigno resultados a un array de instancias del modelo
        $chat = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)) {
            array_push($chat, new Chat($row));

            //echo json_encode($chat);
        }

        //recupero el nombre y el id del usuario al que se esta escribiendo
        //me creo una variable de session de las plazas del viaje
        $rowset = $this->db->query("SELECT * FROM usuarios WHERE id='$id'");

        //Asigno resultado a una instancia del modelo
        $row = $rowset->fetch(\PDO::FETCH_OBJ);
        $usuario = new Usuario($row);
        //me creo una variable de sesion para recuperar las plazas del viaje selecionado y asi con todos los campos del viaje seleccionado
        $_SESSION["aAquienEscribo"] = $usuario->usuario;
        $aNombre = $_SESSION["aAquienEscribo"];

        //Recupero los datos del formulario
        if (isset($_POST["enviar"])) {
            $mensajeChat = filter_input(INPUT_POST, "mensaje", FILTER_SANITIZE_STRING);
            if($mensajeChat=="" || $mensajeChat==" "){
                //$this->view->redireccionConMensaje("admin/usuarios/chatUsuario", "alert-danger", "¡No has escrito nada!");
                $this->view->redireccionConMensaje("admin/usuarios/chatUsuario/$id","alert-danger","Tienes que escribir algo");

                echo "error";
            }else{
                //$this->db->exec("SET GLOBAL time_zone = 'Europe/Madrid'");
                //INTRODUZCO EL MENSAJE A LA BBDD
                $this->db->exec("INSERT INTO chat (mensaje, de, deId, aId, a) VALUES ('$mensajeChat','$deNombre','$deId','$id','$aNombre')");

                echo "enviado";
                $this->view->redireccionConMensaje("admin/usuarios/chatUsuario/$id","alert-sucess","Mensaje Enviado");

            }

        }
        $this->view->vista("admin", "usuarios/chatUsuario", $chat);
    }


    //funcion que te lleva a la ventana de ayuda
    public function ventanaAyuda(){
        $this->view->vista("admin", "usuarios/ayuda");
    }



}