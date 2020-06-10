<?php

/*
 * Noticia y Usuario.

   En ambos cosas consistirán en un construct que recogerá los datos de la consulta a la base de datos (o null si estoy creando uno nuevo) y los asignará a las distintas variables.
 */

namespace App\Model;

class Usuario {

    //Variables o atributos
    var $id;
    var $usuario;
    var $clave;
    var $email;
    var $fecha_acceso;
    var $activo;
    var $usuarios;
    var $viaje;
    var $vreservados;

    function __construct($data=null){

        $this->id = ($data) ? $data->id : null;
        $this->usuario = ($data) ? $data->usuario : null;
        $this->clave = ($data) ? $data->clave : null;
        $this->email = ($data) ? $data->email : null;
        $this->fecha_acceso = ($data) ? $data->fecha_acceso : null;
        $this->activo = ($data) ? $data->activo : null;
        $this->usuarios = ($data) ? $data->usuarios : null;
        $this->viaje = ($data) ? $data->viaje : null;
        $this->vreservados = ($data) ? $data->vreservados : null;

    }
}