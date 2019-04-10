<?php

namespace app\model;

use app\classes\Funcionario;

Interface FuncionarioDAOInterface {

    public function getAllFuncionarios( );

    public function getFuncionarioById( $idFuncionario );

    public function createFuncionario( Funcionario $funcionarioInstancia );

    public function deleteFuncionarioById( $idFuncionario );

    public function updateFuncionarioById( $idFuncionario, Funcionario $funcionarioInstancia );
}