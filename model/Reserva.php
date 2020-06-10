<?php


namespace App\Model;


class Reserva{
    //Variables o atributos
    var $id_reserva;
    var $id_user_reserva;
    var $nombreUserReservado;
    var $uniReserv;
    var $precioReserv;
    var $plazasReserv;
    var $horaIrReserv;
    var $horaVolverReserv;
    var $encuentroReserv;
    var $id_viaje_reservado;

    function __construct($data=null){

        $this->id_reserva = ($data) ? $data->id_reserva : null;
        $this->id_user_reserva = ($data) ? $data->id_user_reserva : null;
        $this->nombreUserReservado = ($data) ? $data->nombreUserReservado : null;
        $this->uniReserv = ($data) ? $data->uniReserv : null;
        $this->precioReserv = ($data) ? $data->precioReserv : null;
        $this->plazasReserv = ($data) ? $data->plazasReserv : null;
        $this->horaIrReserv = ($data) ? $data->horaIrReserv : null;
        $this->horaVolverReserv = ($data) ? $data->horaVolverReserv : null;
        $this->encuentroReserv = ($data) ? $data->encuentroReserv : null;
        $this->id_viaje_reservado = ($data) ? $data->id_viaje_reservado : null;
    }

}