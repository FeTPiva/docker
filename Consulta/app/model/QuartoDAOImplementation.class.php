<?php

namespace app\model;

use app\classes\Quarto;
use app\model\QuartoDAOInterface;
use app\model\ConexaoDB;

class QuartoDAOImplementation implements QuartoDAOInterface
{

    public function getAllQuartos()
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("SELECT * FROM tbl_quarto");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $arrayQuarto = null;
        if ( $stmt->rowCount() > 0 ) {
            $arrayQuarto = array();
            foreach ($result as $row) {
                $QuartoTemp = new Quarto( $row );
                array_push($arrayQuarto, $QuartoTemp);
            }            
        };

        return $arrayQuarto;
    }

    public function getQuartoById( $idQuarto )
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("SELECT * FROM tbl_quarto where idQuarto = :idQuarto");
        $stmt->bindParam(":idQuarto", $idQuarto);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $QuartoTemp = null;
        if ( $stmt->rowCount() > 0 ) {
            $QuartoTemp = new Quarto( $result[0] );
        };

        return $QuartoTemp;
    }

    public function getQuartoByName( string $nome )
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("SELECT * FROM tbl_quarto where `nomeQuarto` = :nomeQuarto");
        $stmt->bindParam(":nomeQuarto", $nome);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $QuartoTemp = null;
        if ( $stmt->rowCount() > 0 ) {
            $QuartoTemp = new Quarto( $result[0] );
        };

        return $QuartoTemp;

    }

    public function createQuarto( Quarto $quartoInstancia )
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("INSERT INTO tbl_quarto (capacidade, descricao, precoDia, nomeQuarto)
         VALUES (:capacidade, :descricao, :precoDia, :nomeQuarto)");

        $stmt->bindParam(":capacidade", $capacidade);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":precoDia", $precoDia);
        $stmt->bindParam(":nomeQuarto", $nomeQuarto);
        
    
        $capacidade = $quartoInstancia->getCapacidade();
        $descricao = $quartoInstancia->getDescricao();
        $precoDia = $quartoInstancia->getPrecoDia();
        $nomeQuarto = $quartoInstancia->getNomeQuarto();

        $stmt->execute();
    }

    public function deleteQuartoById( $idQuarto ):bool
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("DELETE FROM tbl_quarto where idQuarto = :idQuarto");
        $stmt->bindParam(":idQuarto", $idQuarto);

        $stmt->execute();
        return ( $stmt->rowCount() >= 1 );

    }

    public function updateQuartoById( $idQuarto, Quarto $quartoInstancia ):bool
    {
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("UPDATE tbl_quarto SET capacidade = :capacidade, descricao = :descricao,
         precoDia = :precoDia, nomeQuarto = :nomeQuarto
        WHERE idQuarto = $idQuarto");

        $stmt->bindParam(":capacidade", $capacidade);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":precoDia", $precoDia);
        $stmt->bindParam(":nomeQuarto", $nomeQuarto);
        
    
        $capacidade = $quartoInstancia->getCapacidade();
        $descricao = $quartoInstancia->getDescricao();
        $precoDia = $quartoInstancia->getPrecoDia();
        $nomeQuarto = $quartoInstancia->getNomeQuarto();


        $stmt->execute();
        return ( $stmt->rowCount() >= 1 );        
    }
}