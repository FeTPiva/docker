<?php

namespace app\classes;

class Cliente implements \JsonSerializable
{
    private $nome;
    private $cpf;
    private $endereco;
    private $telefone;
    private $email;
    private $senha;
    private $id;

    function __construct( $argsDB = null )
    {
        if ( !is_null($argsDB) ) {
            $this->id = (isset($argsDB["idCliente"])) ? $argsDB["idCliente"] : null ;
            $this->nome = $argsDB["nome"];
            $this->telefone = $argsDB["telefone"];
            $this->cpf = $argsDB["cpf"];
            $this->endereco = $argsDB["endereco"];
            $this->email = $argsDB["email"];
            $this->senha = $argsDB["senha"];
        }
    }

    function getId() {
        return $this->id;
    }

    function setId( $id ) {
        $this->id = $id;
    }


    function getNome() {
        return $this->nome;
    }

    function setNome( $nome ) {
        $this->nome = $nome;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function setEndereco( $endereco ) {
        $this->endereco = $endereco;
    }
    function getCPF() {
        return $this->cpf;
    }
    function setCPF( $cpf ) {
        $this->cpf = $cpf;
    }

      
    function getTelefone() {
        return $this->telefone;
    }

    function setTelefone( $telefone ) {
        $this->telefone = $telefone;
    }
    
   
    function getEmail() {
        return $this->email;
    }

    function setEmail( $email ) {
        $this->email = $email;
    }

   
    function getSenha() {
        return $this->senha;
    }

    function setSenha( $senha ) {
        $this->senha = $senha;
    }

    function __toString() {
        return json_encode( array('idCliente'=>$this->id,
                        'nome' => $this->nome,
                        'telefone' => $this->telefone,
                        'cpf' => $this->cpf,
                        'endereco' => $this->endereco,
                        'email' => $this->email,
                        'senha'=> $this->senha
                          ) );
    }

    public function jsonSerialize()
    {
        return array( 'idCliente'=>$this->id,
                      'nome' => $this->nome,
                      'telefone' => $this->telefone,
                      'cpf' => $this->cpf,
                      'endereco' => $this->endereco,
                      'email' => $this->email,
                      'senha'=> $this->senha);
    }
}