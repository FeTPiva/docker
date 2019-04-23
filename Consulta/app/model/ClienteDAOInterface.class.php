<?php

namespace app\model;

use app\classes\Cliente;

Interface ClienteDAOInterface {

    public function getAllClientes( );

    public function getClienteByName( string $nome );

    public function getClienteById( $idCliente );

    public function createCliente( Cliente $clienteInstancia );

    public function deleteClienteById( $idCliente );

    public function updateClienteById( $idCliente, Cliente $clienteInstancia );
}