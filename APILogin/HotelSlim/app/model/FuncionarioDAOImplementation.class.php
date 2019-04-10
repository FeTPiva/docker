<?php

namespace app\model;

use app\classes\Funcionario;
use app\model\FuncionarioDAOInterface;
use app\model\ConexaoDB;

class FuncionarioDAOImplementation implements FuncionarioDAOInterface
{

    public function getAllFuncionarios()
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("SELECT * FROM tbl_funcionario");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $arrayFuncionario = null;
        if ( $stmt->rowCount() > 0 ) {
            $arrayFuncionario = array();
            foreach ($result as $row) {
                $FuncionarioTemp = new Funcionario( $row );
                array_push($arrayFuncionario, $FuncionarioTemp);
            }            
        };

        return $arrayFuncionario;
    }

    public function getFuncionarioById( $idFuncionario )
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("SELECT * FROM tbl_funcionario where idFuncionario = :idFuncionario");
        $stmt->bindParam(":idFuncionario", $idFuncionario);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $FuncionarioTemp = null;
        if ( $stmt->rowCount() > 0 ) {
            $FuncionarioTemp = new Funcionario( $result[0] );
        };

        return $FuncionarioTemp;
    }

    public function createFuncionario( Funcionario $funcionarioInstancia )
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("INSERT INTO tbl_funcionario (login, senha)
         VALUES (:login, :senha)");

        $stmt->bindParam(":login", $login);
        $stmt->bindParam(":senha", $senha);
    
        $login = $funcionarioInstancia->getLogin();
        $senha = $funcionarioInstancia->getSenha();
        $stmt->execute();
    }

    public function deleteFuncionarioById( $idFuncionario ):bool
    {
        # Pode lançar erro
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("DELETE FROM tbl_funcionario where idFuncionario = :idFuncionario");
        $stmt->bindParam(":idFuncionario", $idFuncionario);

        $stmt->execute();
        return ( $stmt->rowCount() >= 1 );

    }

    public function updateFuncionarioById( $idFuncionario, Funcionario $funcionarioInstancia ):bool
    {
        $connDB = new ConexaoDB();
        $stmt = $connDB->con->prepare("UPDATE tbl_funcionario SET login = :login, senha = :senha
        WHERE idFuncionario = $idFuncionario");

        
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':senha', $senha);

        
        $login = $funcionarioInstancia->getLogin();
        $senha = $funcionarioInstancia->getSenha();
        $stmt->execute();
        return ( $stmt->rowCount() >= 1 );        
    }
}