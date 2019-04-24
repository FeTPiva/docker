<?php

namespace app\classes;

class Funcionario implements \JsonSerializable
{
    private $id;
    private $login;
    private $senha;
   
    function __construct( $argsDB = null )
    {
        if ( !is_null($argsDB) ) {
            $this->id = (isset($argsDB["idFuncionario"])) ? $argsDB["idFuncionario"] : null ;
            $this->login = $argsDB["login"];
            $this->senha = $argsDB["senha"];
        }
    }


    function getId() {
        return $this->id;
    }

    function setId( $id ) {
        $this->id = $id;
    }

    function getLogin() {
        return $this->login;
    }

    function setLogin( $login ) {
         $this->login = $login;
    }

    function getSenha() {
        return $this->senha;
    }

    function setSenha( $senha ) {
        $this->senha = $senha;
    }

    function __toString() {
        return json_encode( array( 'id' => $this->id,
                        'login' => $this->login,
                        'senha' => $this->senha) );
    }


    
    public function jsonSerialize()
    {
        return array(  'id' => $this->id,
                       'login' => $this->login,
                       'senha' => $this->senha );

    }
}