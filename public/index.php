<?php
/*
 * Por el archivo public/index.php deben pasar todas las peticiones a nuestro web, pues será el encargado de encaminar las peticiones a las acciones y vistas correspondientes mediante un sistema de toma de decisiones.
 *
 * el autoload o pre-carga de clases necesarias y definirá una serie de variables de sesión para su uso a lo largo de las distintas páginas.
 */
namespace App;
//Inicializo sesión para poder traspasar variables entre páginas
session_start();
//Incluyo los controladores que voy a utilizar para que seran cargados por Autoload
use App\Controller\AppController;
use App\Controller\NoticiaController;
use App\Controller\UsuarioController;
use App\Controller\ViajeController;

//phpinfo();
/*
 * Asigno a sesión las rutas de las carpetas public y home, necesarias tanto para las rutas como para
 * poder enlazar imágenes y archivos css, js
 */

//echo password_hash("12345678",  PASSWORD_BCRYPT, ['cost'=>12]);

$_SESSION['public'] = '/aaaProyectoFinalCEUcar/public/';
$_SESSION['home'] = $_SESSION['public'].'index.php/';
//Defino y llamo a la función que autocargará las clases cuando se instancien
spl_autoload_register('App\autoload');
function autoload($clase,$dir=null){
    //Directorio raíz de mi proyecto
    if (is_null($dir)){
        $dirname = str_replace('/public', '', dirname(__FILE__));
        $dir = realpath($dirname);
    }
    //Escaneo en busca de la clase de forma recursiva
    foreach (scandir($dir) as $file){
        //Si es un directorio (y no es de sistema) accedo y
        //busco la clase dentro de él
        if (is_dir($dir."/".$file) AND substr($file, 0, 1) !== '.'){
            autoload($clase, $dir."/".$file);
        }
        //Si es un fichero y el nombr conicide con el de la clase
        else if (is_file($dir."/".$file) AND $file == substr(strrchr($clase, "\\"), 1).".php"){
            require($dir."/".$file);
        }
    }
}
//Para invocar al controlador en cada ruta
function controlador($nombre=null){
    switch($nombre){
        default: return new AppController;
        case "usuarios": return new UsuarioController;
        case "viajes": return new ViajeController;
    }
}
//Quito la ruta de la home a la que me están pidiendo
$ruta = str_replace($_SESSION['home'], '', $_SERVER['REQUEST_URI']);

//Encamino cada ruta al controlador y acción correspondientes
switch ($ruta){

    case "admin":
    case "admin/entrar":
        controlador("usuarios")->entrar();
        break;
    case "admin/salir":
        controlador("usuarios")->salir();
        break;
    case "admin/usuarios":
        controlador("usuarios")->index();
        break;
    case "admin/viajes/publicarViajes":
        controlador("viajes")->publicar();
        break;
    case "admin/viajes/listadoViajes":
        controlador("viajes")->listaViajes();
        break;
    case "admin/viajes/viajesReservados":
        controlador("viajes")->viajesReservados();
        break;
//    PARA VER LA VENTANA DE AYUDA
     case "admin/usuarios/ayuda":
            controlador("usuarios")->ventanaAyuda();
            break;
    //    PARA VER LA VENTANA DE CHAT
    case "admin/usuarios/chats":
        controlador("usuarios")->chats();
        break;
    //    PARA VER LA VENTANA DE CHAT PRIVADO DEL USUARIO

    case (strpos($ruta,"admin/usuarios/chatUsuario/") === 0):
        controlador("usuarios")->chatUsuarioPrivado(str_replace("admin/usuarios/chatUsuario/","",$ruta));
        break;
//    case "admin/viajes/reservarViaje":
//        controlador("viajes")->confirReservaViaje();
//        break;

//         ¡ESTE! ->
    case (strpos($ruta,"admin/viajes/reservarViaje/") === 0):
        controlador("viajes")->reservarViaje(str_replace("admin/viajes/reservarViaje/","",$ruta));
        break;

//      <--

    case "admin/usuarios/miPerfil":
        controlador("usuarios")->miPerfil();
        break;
    case (strpos($ruta,"admin/viajes/borrar/") === 0):
        controlador("viajes")->borrar(str_replace("admin/viajes/borrar/","",$ruta));
        break;
    case (strpos($ruta,"admin/viajes/borrarReserv/") === 0):
        controlador("viajes")->borrarReserv(str_replace("admin/viajes/borrarReserv/","",$ruta));
        break;
    case (strpos($ruta,"admin/usuarios/editar/") === 0):
        controlador("usuarios")->editar(str_replace("admin/usuarios/editar/","",$ruta));
        break;
//        para activar al usuario y permitirle el login
    case (strpos($ruta,"admin/usuarios/activar/") === 0):
        controlador("usuarios")->activar(str_replace("admin/usuarios/activar/","",$ruta));
        break;
//        para banear al usuario y que no pueda entrar
    case (strpos($ruta,"admin/usuarios/banear/") === 0):
        controlador("usuarios")->banear(str_replace("admin/usuarios/banear/","",$ruta));
        break;
//        para borrar al usuario de la BBDD
    case (strpos($ruta,"admin/usuarios/elimUsuario/") === 0):
        controlador("usuarios")->elimUsuario(str_replace("admin/usuarios/elimUsuario/","",$ruta));
        break;
    //        para que el usuario meta el codigo enviado al email y active su cuenta
    case (strpos($ruta,"admin/usuarios/activarConCodigo/") === 0):
        controlador("usuarios")->activarConCodigo(str_replace("admin/usuarios/activarConCodigo/","",$ruta));
        break;
    case "admin/publicarOver":
        //echo"ventana para publicar viajes o verlos";
        controlador("viajes")->publicar();
        break;
    case "admin/noticias/crear":
        controlador("noticias")->crearPartida();
        break;
    case (strpos($ruta,"admin/noticias/editar/") === 0):
        controlador("noticias")->editar(str_replace("admin/noticias/editar/","",$ruta));
        break;
    case (strpos($ruta,"admin/noticias/activar/") === 0):
        controlador("noticias")->activar(str_replace("admin/noticias/activar/","",$ruta));
        break;
    case (strpos($ruta,"admin/noticias/home/") === 0):
        controlador("noticias")->home(str_replace("admin/noticias/home/","",$ruta));
        break;
    case (strpos($ruta,"admin/noticias/borrar/") === 0):
        controlador("noticias")->borrar(str_replace("admin/noticias/borrar/","",$ruta));
        break;
    case (strpos($ruta,"admin/") === 0):
        controlador("usuarios")->entrar();
        break;
    //Resto de rutas

    default:
        //controlador()->index();
        //controlador()->admin();
        controlador("usuarios")->entrar();
    //controlador("usuarios")->registrar();
}
?>
