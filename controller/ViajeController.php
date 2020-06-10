<?php
namespace App\Controller;

use App\Helper\ViewHelper;
use App\Helper\DbHelper;
use App\Model\Reserva;
use App\Model\Viaje;

//estos uses son para la verificacion de email
require '../phpmailer/plugins/PHPMailer/src/Exception.php';
require '../phpmailer/plugins/PHPMailer/src/PHPMailer.php';
require '../phpmailer/plugins/PHPMailer/src/SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ViajeController{

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

    public function publicar(){

        $userEmailPublic = $_SESSION['email_usuario'];

        if (isset($_POST["publicar"])) {
            //Recupero los datos del formulario
            $universidad = filter_input(INPUT_POST, "universidad", FILTER_SANITIZE_STRING);
            $localizacion = filter_input(INPUT_POST, "lquedada", FILTER_SANITIZE_STRING);
            $hora_ir = filter_input(INPUT_POST, "horair", FILTER_SANITIZE_STRING);
            $hora_volver = filter_input(INPUT_POST, "horavolver", FILTER_SANITIZE_STRING);
            $num_plazas = filter_input(INPUT_POST, "plazas", FILTER_SANITIZE_STRING);
            $precio = filter_input(INPUT_POST, "dinero", FILTER_SANITIZE_STRING);

            if ($localizacion == "" || $hora_ir == "" || $hora_volver == "" || $precio == "" || $universidad == "defect" || $num_plazas == "defect") {
                $this->view->redireccionConMensaje("admin", "alert-danger", "Comprueba que has rellenado los campos.");

            } else {

                //obtengo el id de usuario para cuando lo agrege a la lista de viajes sepa ese viaje de que user es por el id
                $idUserViaje = $_SESSION["id_usuario"];
                //obtengo el numero de viajes que tiene el usuario que se ha metido para luego sumarle 1 mas cuando publique un viaje
                $numViajesDelUsuario = $_SESSION["num_viajes_usuario"];
                //sumo 1 al los viajes que tenia
                $resultViajesUser = $numViajesDelUsuario + 1;
                //guardamos el nombre de usuario de la sesion para cuando publiquemos el viaje se sepa que usuario ha sido
                $nombreUserViajePublic = $_SESSION["usuario"];

                //Creo un nuevo viaje
                $this->db->exec("INSERT INTO viaje (id_user_viaje, lugarQuedada, uni, precio, plazasDisponibles, hora_ir, hora_volver, nombreUserViaje, email_user_viaje) VALUES ('$idUserViaje','$localizacion','$universidad','$precio','$num_plazas','$hora_ir','$hora_volver','$nombreUserViajePublic', '$userEmailPublic')");

                //creo otra sentencia SQL para sumar 1 viaje mas al usuario que lo ha creado UPDATE
                $this->db->exec("UPDATE usuarios SET viaje='$resultViajesUser' WHERE id='$idUserViaje'");


                //echo "publicado";
                $this->view->redireccionConMensaje("admin/viajes/listadoViajes", "alert-success", "Viaje Publicado correctamente!");

            }
        }else{
            //Llamo a la vista
            $this->view->vista("admin", "viajes/publicarViajes");
        }

    }

    public function listaViajes(){

        //es por defecto me salen los viajes ordenados segun su id
        if ( !isset($_POST["ordenarasc"])) {
            //Consulta a la bbdd
            $rowset = $this->db->query("SELECT * FROM viaje ORDER BY id_viaje ASC");

            //Asigno resultados a un array de instancias del modelo
            $viaje = array();
            while ($row = $rowset->fetch(\PDO::FETCH_OBJ)) {
                array_push($viaje, new Viaje($row));
            }

            //echo "llego";
            //Llamo a la vista
            //$this->view->vista("admin", "noticias/index", $partida);
            //Llamo a la vista
            $this->view->vista("admin", "viajes/listadoViajes", $viaje);

        }else {
            //en el caso de que de al boton ordenara los viajes segun lo barato que sean
            //Consulta a la bbdd
            $rowset = $this->db->query("SELECT * FROM viaje ORDER BY precio ASC");

            //Asigno resultados a un array de instancias del modelo
            $viaje = array();
            while ($row = $rowset->fetch(\PDO::FETCH_OBJ)) {
                array_push($viaje, new Viaje($row));
            }

            //echo "llego";
            //Llamo a la vista
            //$this->view->vista("admin", "noticias/index", $partida);
            //Llamo a la vista
            $this->view->vista("admin", "viajes/listadoViajes", $viaje);
        }
    }

    //eliminar viaje del usuario
    public function borrar($id_viaje){
        //obtengo el id de usuario para cuando borre un viaje modifique a la lista de viajes sepa ese viaje de que user es por el id
        $idUserViaje= $_SESSION["id_usuario"];
        //obtengo el numero de viajes que tiene el usuario que se ha metido para luego restarle 1 cuando lo borre el selecionado
        $numViajesDelUsuario =  $_SESSION["num_viajes_usuario"];
        //cogemos los viajes en total que tiene y le restamos 1
        $resultViajesUserRestado = $numViajesDelUsuario - 1;


        //Permisos
        $this->view->permisos("usuarios");

        //Borro el usuario
        $consulta = $this->db->exec("DELETE FROM viaje WHERE id_viaje='$id_viaje'");

        //creo otra sentencia SQL para restar 1 viaje al usuario que ha borrado el viaje selecionado
        $this->db->exec("UPDATE usuarios SET viaje='$resultViajesUserRestado' WHERE id='$idUserViaje'");


        //Mensaje y redirección
        ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
            $this->view->redireccionConMensaje("admin/usuarios/miPerfil","alert-success","Viaje eliminado correctamente") :
            $this->view->redireccionConMensaje("admin/usuarios/miPerfil","alert-danger","Error al borrar el viaje");
    }

    //funcion en el que recupero el viaje pinchado por el usuario
    public function reservarViaje($id_viaje){

        $userIdReserv = $_SESSION["id_usuario"];
        $userNombreReserv = $_SESSION['usuario'];
        $userEmailReserv = $_SESSION['email_usuario'];


        //transformo el $id_viaje y recupero solo el numero
        //asi en lugar de que el id_viaje sea 4?reserva=reserva extraigo solo el valor numérico
        $idViajeConvert = intval(preg_replace('/[^0-9]+/', "", $id_viaje));


        //me creo una variable de session de las plazas del viaje
        $rowset = $this->db->query("SELECT * FROM viaje WHERE id_viaje='$idViajeConvert'");

        //Asigno resultado a una instancia del modelo
        $row = $rowset->fetch(\PDO::FETCH_OBJ);
        $viaje = new Viaje($row);
        //me creo una variable de sesion para recuperar las plazas del viaje selecionado y asi con todos los campos del viaje seleccionado
        $_SESSION["plazasViajeDispo"] = $viaje->plazasDisponibles;
        $plazasViajeDisponi = $_SESSION["plazasViajeDispo"];
        //UNI
        $_SESSION["uniReservada"] = $viaje->uni;
        $uniReservada = $_SESSION["uniReservada"];
        //LUGAR DE ENCUENTRO
        $_SESSION["encuentroReservada"] = $viaje->lugarQuedada;
        $encuentroReservada = $_SESSION["encuentroReservada"];
        //PRECIO
        $_SESSION["precioReservada"] = $viaje->precio;
        $precioReservada = $_SESSION["precioReservada"];
        //PLAZAS / ASIENTOS
        $plazasReservada = 1;
        //HORA IR
        $_SESSION["horaIrReservada"] = $viaje->hora_ir;
        $horaIrReservada = $_SESSION["horaIrReservada"];
        //HORA VOLVER
        $_SESSION["horaVolverReservada"] = $viaje->hora_volver;
        $horaVolverReservada = $_SESSION["horaVolverReservada"];
        //EMAIL VIAJE USER
        $_SESSION["emailUserReservada"] = $viaje->email_user_viaje;
        $emailUserViajeReservada = $_SESSION["emailUserReservada"];

        //al darle al boton
        //ES $_GET EN LUGAR DE $_POST por que se lo paso por url los datos
        if (isset($_GET["reservar"])){
            //hago la comprobacion de que si el viaje ya tiene 0 plazas no se pueda reservar
            if($plazasViajeDisponi == 0){
                $this->view->redireccionConMensaje("admin/viajes/reservarViaje/$idViajeConvert","alert-danger","Ya no quedan plazas disponibles ");

            }else {
                //        recupero lo que pone en el campo de mensaje
                $mensaje = filter_input(INPUT_GET, "textoMensaje", FILTER_SANITIZE_STRING);

                //MODO PARA ENVIAR MENSAJE DE RESERVA DE VIAJE AL EMAIL
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
                $mail->addAddress($emailUserViajeReservada, 'nuevo usuario');
                $mail->Subject = 'Viaje reservado en CEUcar!';
                $mail->msgHTML("
                            <html>
                                <body>
                                    <strong>HOLA!</strong><br>
                                    <br>
                                    Tienes una persona que esta interesada en tu viaje publicado y ha reservado una plaza.<br><br>
                                    Su email para ponerse en contacto es: $userEmailReserv y su nombre <strong>$userNombreReserv </strong><br><br>
                                    El viaje que le ha interesado es en el que quedais en <strong>$encuentroReservada</strong> para ir a la universidad de <strong>$uniReservada</strong> <br><br>
                                    <strong>Su mensaje: </strong><br><br>
                                    $mensaje<br><br>
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
                    $this->view->redireccionConMensaje("admin/viajes/listadoViajes","alert-danger","Hubo un error inesperado");

                }else{
                    //resto 1 al los asientos que tenia del viaje
                    $resultPlazasViajeDis = $plazasViajeDisponi - 1;

                    //AQUI ASGINAMOS EN LA TABLA USUARIOS LOS VIAJES RESERVADOS A 1 PARA QUE LE SALGA LA VENTANA DE VIJAES RESERVADOS
                    $this->db->exec("UPDATE usuarios SET vreservados='1' WHERE id='$userIdReserv'");

                    //AQUI RESTO 1 PLAZA AL VIAJE QUE HABIA PUBLICADO Y SE A RESERVADO
                    $this->db->exec("UPDATE viaje SET plazasDisponibles='$resultPlazasViajeDis' WHERE id_viaje='$idViajeConvert'");

                    //CREO EL VIAJE RESERVADO UNIDO AL USUARIO QUE LO RESERVO
                    $this->db->exec("INSERT INTO reserva (id_user_reserva, nombreUserReservado, uniReserv, precioReserv, plazasReserv, horaIrReserv, horaVolverReserv, encuentroReserv, id_viaje_reservado) VALUES ('$userIdReserv','$userNombreReserv','$uniReservada','$precioReservada','$plazasReservada','$horaIrReservada','$horaVolverReservada','$encuentroReservada','$idViajeConvert')");


                    //cierro las SESSION que he abierto para el viaje
                    unset($_SESSION["plazasViajeDispo"]);
                    unset($_SESSION["uniReservada"]);
                    unset($_SESSION["encuentroReservada"]);
                    unset($_SESSION["precioReservada"]);
                    unset($_SESSION["horaIrReservada"]);
                    unset($_SESSION["horaVolverReservada"]);
                    //echo $idViajeConvert;
                    $this->view->redireccionConMensaje("admin/viajes/listadoViajes", "alert-success", "Viaje reservado correctamente");

                }

            }
        }

        //Consulta a la bbdd
        $rowset = $this->db->query("SELECT * FROM viaje WHERE id_viaje='$id_viaje'");

        //Asigno resultados a un array de instancias del modelo
        $viaje = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
            array_push($viaje,new Viaje($row));
        }


        //Llamo a la vista
        $this->view->vista("admin", "viajes/reservarViaje", $viaje);

        //-------------------------------------------------------------------------------------------

        //Permisos
        //$this->view->permisos("usuarios");

        //Si ha pulsado el botón de guardar
//        if (isset($_POST["reservar"])){
//
//            echo "hola";
//
//        }
//
//        //si no se pulsa al boton hace esto
//        else{
//            //Consulta a la bbdd
//            $rowset = $this->db->query("SELECT * FROM viaje WHERE id_viaje='$id_viaje'");
//
//            //Asigno resultados a un array de instancias del modelo
//            $viaje = array();
//            while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
//                array_push($viaje,new Viaje($row));
//            }
//
//
//            //Llamo a la vista
//            $this->view->vista("admin", "viajes/reservarViaje", $viaje);
//        }



    }

    //funcion en la que el usuario reserva el viaje y le resta 1 a las plazas del viaje
    public function confirReservaViaje(){
        echo "hola";
    }


    //pagina donde salen los viajes reservados por el usuario
    public function viajesReservados(){
       //mostrar de la tabla de viajes reservados los viajes segun el id
        //echo $_SESSION["num_viajes_usuario_reservados"];
        $usuarioActivo = $_SESSION['usuario'];
        //Consulta a la bbdd solo los viajes del usuario
        $rowset = $this->db->query("SELECT * FROM reserva WHERE  nombreUserReservado='$usuarioActivo' ORDER BY id_reserva DESC");

        //Asigno resultados a un array de instancias del modelo
        $reserva = array();
        while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
            array_push($reserva,new Reserva($row));
        }


        //Llamo a la vista
        $this->view->vista("admin", "viajes/viajesReservados", $reserva);
    }

    //eliminar viaje reservado por el usuario
    public function borrarReserv($id_reserva){
        //me creo la consulta para obtener una variable de session y recuperar el id del viaje de la reserva a eliminar
        $rowset = $this->db->query("SELECT * FROM reserva WHERE id_reserva='$id_reserva'");

        //Asigno resultado a una instancia del modelo
        $row = $rowset->fetch(\PDO::FETCH_OBJ);
        $reserva = new Reserva($row);
        //me creo una variable de sesion para recuperar el id del viaje de reserva selecionado
        $_SESSION["idViajeReservaAEliminar"] = $reserva->id_viaje_reservado;

        $idViajeReservaAEliminar = $_SESSION["idViajeReservaAEliminar"];

        //-------------------------------------------------------------------------------------
        //ahora me creo otra consulta para recuperar las plazas del que fue hecha la reserva del viaje selecionado
        $rowset = $this->db->query("SELECT * FROM viaje WHERE id_viaje='$idViajeReservaAEliminar'");

        //Asigno resultado a una instancia del modelo
        $row = $rowset->fetch(\PDO::FETCH_OBJ);
        $viaje = new Viaje($row);
        //me creo una variable de sesion para recuperar el id del viaje de reserva selecionado
        $_SESSION["plazasViaje"] = $viaje->plazasDisponibles;
        $plazasViaje = $_SESSION["plazasViaje"];
        //y sumo 1 a las plazas que tenia el viaje
        $plazasViajeSum= $plazasViaje + 1;


        //Permisos
        $this->view->permisos("usuarios");

        //Borro el viaje reservado del usuario
        $consulta = $this->db->exec("DELETE FROM reserva WHERE id_reserva='$id_reserva'");
        //$consulta = $this->db->exec("DELETE FROM reserva WHERE id_reserva='99'");

        //creo otra sentencia SQL para sumar 1 a la plaza del viaje selecionado
        $this->db->exec("UPDATE viaje SET plazasDisponibles='$plazasViajeSum' WHERE id_viaje='$idViajeReservaAEliminar'");


        //Mensaje y redirección
        ($consulta > 0) ? //Compruebo consulta para ver que no ha habido errores
            $this->view->redireccionConMensaje("admin/viajes/viajesReservados","alert-success","Reserva de viaje eliminada") :
            $this->view->redireccionConMensaje("admin/viajes/viajesReservados","alert-danger","Error al eliminar la reserva");

    }


}