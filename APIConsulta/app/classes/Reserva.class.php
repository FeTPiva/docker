<?php

namespace app\classes;

class Reserva implements \JsonSerializable
{
    private $idReserva;
    private $idCliente;
    private $idQuarto;
    private $precoTotal;
    private $dataDia;
    private $dataMes;
    private $dataAno;
    private $qntDias;


    function __construct( $argsDB = null )
    {
        if ( !is_null($argsDB) ) {
            $this->idReserva = (isset($argsDB["idReserva"])) ? $argsDB["idReserva"] : null ;
            $this->idCliente = $argsDB["idClienteReserva"];
            $this->idQuarto = $argsDB["idQuartoReserva"];
            $this->precoTotal = $argsDB["precoTotal"];
            $this->dataDia = $argsDB["dataDia"];
            $this->dataMes = $argsDB["dataMes"];
            $this->dataAno = $argsDB["dataAno"];
            $this->qntDias = $argsDB["qntDias"];
        }
    }

    function getIdReserva() {
        return $this->idReserva;
    }

    function setIdReserva( $idReserva ) {
        $this->idReserva = $idReserva;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function setIdCliente( $idCliente ) {
        $this->idCliente= $idCliente; 
    }

    function getIdQuarto() {
        return $this->idQuarto;
    }

    function setIdQuarto( $idQuarto ) {
        $this->idQuarto = $idQuarto;
    }

    function getPrecoTotal() {
        return $this->precoTotal;
    }

    function setPrecoTotal( $precoTotal ) {
        $this->precoTotal = $precoTotal;
    }

    function getDataDia() {
        return $this->dataDia;
    }

    function setDataDia( $dataDia ) {
        $this->dataDia = $dataDia;
    }

    function getDataMes() {
        return $this->dataMes;
    }

    function setDataMes( $dataMes ) {
        $this->dataMes = $dataMes;
    }

    function getDataAno() {
        return $this->dataAno;
    }

    function setDataAno( $dataAno ) {
        $this->dataAno = $dataAno;
    }

    function getQntDias() {
        return $this->qntDias;
    }

    function setQntDias( $qntDias ) {
        $this->qntDias = $qntDias;
    }


    function __toString() {
        return json_encode( array( 'idReserva' => $this->idReserva,
                        'idQuartoReserva' => $this->idQuarto,
                        'idClienteReserva' => $this->idCliente,
                        'precoTotal' => $this->precoTotal,
                        'dataDia' => $this->dataDia,
                        'dataMes' => $this->dataMes,
                        'dataAno' => $this->dataAno,
                        'qntDias' => $this->qntDias) );
    }


 
    
    public function jsonSerialize()
    {
        return array('idReserva' => $this->idReserva,
                    'idQuartoReserva' => $this->idQuarto,
                    'idClienteReserva' => $this->idCliente,
                    'precoTotal' => $this->precoTotal,
                    'dataDia' => $this->dataDia,
                    'dataMes' => $this->dataMes,
                    'dataAno' => $this->dataAno,
                    'qntDias' => $this->qntDias);
    }
}