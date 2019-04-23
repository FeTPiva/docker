<?php

namespace app\classes;

class Quarto implements \JsonSerializable
{
    private $id;
    private $capacidade;
    private $descricao;
    private $precoDia;
    private $nomeQuarto;

    function __construct( $argsDB = null )
    {
        if ( !is_null($argsDB) ) {
            $this->id = (isset($argsDB["idQuarto"])) ? $argsDB["idQuarto"] : null ;
            $this->capacidade = $argsDB["capacidade"];
            $this->descricao = $argsDB["descricao"];
            $this->precoDia = $argsDB["precoDia"];
            $this->nomeQuarto = $argsDB["nomeQuarto"];
        }
    }

    function getId() {
        return $this->id;
    }

    function setId( $id ) {
        $this->id = $id;
    }

    function getCapacidade() {
        return $this->capacidade;
    }

    function setCapacidade( $capacidade ) {
        $this->capacidade = $capacidade;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function setDescricao( $descricao ) {
        $this->descricao = $descricao;
    }

    function getPrecoDia() {
        return $this->precoDia;
    }
    
    function setPrecoDia( $precoDia ) {
        $this->precoDia = $precoDia;
    }

    function getNomeQuarto() {
        return $this->nomeQuarto;
    }

    function setNomeQuarto( $contato ) {
        $this->contato = $contato;
    }

    function __toString() {
        return json_encode( array( 'idQuarto' => $this->id,
                        'capacidade' => $this->capacidade,
                        'descricao' => $this->descricao,
                        'precoDia' => $this->precoDia,
                        'nomeQuarto' => $this->nomeQuarto) );
    }



    
    public function jsonSerialize()
    {
        return array( 'idQuarto' => $this->id,
        'capacidade' => $this->capacidade,
        'descricao' => $this->descricao,
        'precoDia' => $this->precoDia,
        'nomeQuarto' => $this->nomeQuarto);
        }
}