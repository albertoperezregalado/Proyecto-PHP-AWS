<?php


namespace App\Model;


class Chat{

    //Variables o atributos
    var $id_chat;
    var $mensaje;
    var $deId;
    var $de;
    var $aId;
    var $a;
    var $creado;

    function __construct($data=null){

        $this->id_chat = ($data) ? $data->id_chat : null;
        $this->mensaje = ($data) ? $data->mensaje : null;
        $this->deId = ($data) ? $data->deId : null;
        $this->de = ($data) ? $data->de : null;
        $this->aId = ($data) ? $data->aId : null;
        $this->a = ($data) ? $data->a : null;
        $this->creado = ($data) ? $data->creado : null;

    }

}