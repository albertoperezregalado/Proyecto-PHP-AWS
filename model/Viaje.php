<?php



namespace App\Model;

class Viaje {

    //Variables o atributos
    var $id_viaje;
    var $id_user_viaje;
    var $lugarQuedada;
    var $uni;
    var $precio;
    var $plazasDisponibles;
    var $hora_ir;
    var $hora_volver;
    var $nombreUserViaje;
    var $email_user_viaje;

    function __construct($data=null){

        $this->id_viaje = ($data) ? $data->id_viaje : null;
        $this->id_user_viaje = ($data) ? $data->id_user_viaje : null;
        $this->lugarQuedada = ($data) ? $data->lugarQuedada : null;
        $this->uni = ($data) ? $data->uni : null;
        $this->precio = ($data) ? $data->precio : null;
        $this->plazasDisponibles = ($data) ? $data->plazasDisponibles : null;
        $this->hora_ir = ($data) ? $data->hora_ir : null;
        $this->hora_volver = ($data) ? $data->hora_volver : null;
        $this->nombreUserViaje = ($data) ? $data->nombreUserViaje : null;
        $this->email_user_viaje = ($data) ? $data->email_user_viaje : null;
    }
}