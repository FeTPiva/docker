<?php

namespace app\model;

use app\classes\Reserva;

Interface ReservaDAOInterface {

    public function getAllReservas( );

    public function getReservaById( $idReserva );

    public function createReserva( Reserva $reservaInstancia, $idQuarto, $cpfCliente );

    public function deleteReservaById( $idReserva );

    public function updateReservaById(  $idReserva, Reserva $reservaInstancia, $idQuarto, $cpfCliente );
}