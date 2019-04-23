<?php

namespace app\model;

use app\classes\Cliente;
use app\model\ClienteDAOInterface;
use app\model\ConexaoDB;

class ClienteDAOImplementation implements ClienteDAOInterface
{

    public function getAllClientes()
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("SELECT * FROM tbl_cliente");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $arrayCliente = null;
        if ( $stmt->rowCount() > 0 ) {
            $arrayCliente = array();
            foreach ($result as $row) {
                $ClienteTemp = new Cliente( $row );
                array_push($arrayCliente, $ClienteTemp);
            }            
        };

        return $arrayCliente;
    }

    public function getClienteById( $idCliente )
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("SELECT * FROM tbl_cliente where idCliente = :idCliente");
        $stmt->bindParam(":idCliente", $idCliente);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $ClienteTemp = null;
        if ( $stmt->rowCount() > 0 ) {
            $ClienteTemp = new Cliente( $result[0] );
        };

        return $ClienteTemp;
    }

    public function getClienteByName( string $nome )
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("SELECT * FROM tbl_cliente where nome = :nome");
        $stmt->bindParam(":nome", $nome);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $ClienteTemp = null;
        if ( $stmt->rowCount() > 0 ) {
            $ClienteTemp = new Cliente( $result[0] );
        };

        return $ClienteTemp;

    }

    public function createCliente( Cliente $clienteInstancia )
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("INSERT INTO tbl_cliente (nome, telefone, cpf, endereco, email, senha)
         VALUES (:nome, :telefone, :cpf, :endereco, :email, :senha)");

        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":telefone", $telefone);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->bindParam(":endereco", $endereco);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);
    
        $nome = $clienteInstancia->getNome();
        $telefone = $clienteInstancia->getTelefone();
        $cpf = $clienteInstancia->getCPF();
        $endereco = $clienteInstancia->getEndereco();
        $email = $clienteInstancia->getEmail();
        $senha = $clienteInstancia->getSenha();
        $stmt->execute();
    }

    public function deleteClienteById( $idCliente ):bool
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("DELETE FROM tbl_cliente where idCliente = :idCliente");
        $stmt->bindParam(":idCliente", $idCliente);

        $stmt->execute();
        return ( $stmt->rowCount() >= 1 );

    }

    public function updateClienteById( $idCliente, Cliente $clienteInstancia ):bool
    {
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("UPDATE tbl_cliente SET nome = :nome, cpf = :cpf,
         telefone = :telefone, endereco = :endereco, email = :email, senha = :senha
        WHERE idCliente = $idCliente");

        
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        
        $nome = $clienteInstancia->getNome();
        $telefone = $clienteInstancia->getTelefone();
        $cpf = $clienteInstancia->getCPF();
        $endereco = $clienteInstancia->getEndereco();
        $email = $clienteInstancia->getEmail();
        $senha = $clienteInstancia->getSenha();
        $stmt->execute();
        return ( $stmt->rowCount() >= 1 );        
    }
}