<?php

namespace app\controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use app\model\FuncionarioDAOImplementation as FuncionarioDAO;
use app\classes\BadHttpRequest;
use app\classes\Funcionario;


class ControladorApp
{
    
    ///////////////////////////////////// FUNCIONARIO ///////////////////////////////////////

    public function lerTodosFuncionarios( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            $dao = new FuncionarioDAO();
            $funcionariosArray = $dao->getAllFuncionarios();

            $corpoResp =  json_encode( array( "funcionario" =>$funcionariosArray ) );
            $response = $response->withHeader('Content-type', 'application/json')
                                 ->write( $corpoResp );
        } catch ( \PDOException $e ) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } 
        return $response->withStatus($status);
    }

    public function lerFuncionario( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            # Verifica o argumento que vem via URL
            if ( isset( $args["idFuncionario"]) ) {
                if ( !is_numeric( $args["idFuncionario"] ) )
                    throw new BadHttpRequest();
            } else { 
                throw new BadHttpRequest();
            }

            $dao = new FuncionarioDAO();
            $funcionario = $dao->getFuncionarioById( $args["idFuncionario"] );

            $status = ( !is_null( $funcionario ) ) ? 200 : 204; 

            $corpoResp =  json_encode( $funcionario );
            $response = $response->withHeader('Content-type', 'application/json')
                                 ->write( $corpoResp );
        } catch (BadHttpRequest $e) {
            $status = 400;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } catch ( \PDOException $e ) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } 
        return $response->withStatus($status);
    }

    public function deletarFuncionario( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            # Verifica o argumento que vem via URL
            if ( isset( $args["idFuncionario"]) ) {
                if ( !is_numeric( $args["idFuncionario"] ) )
                    throw new BadHttpRequest();
            } else { 
                throw new BadHttpRequest();
            }

            $dao = new FuncionarioDAO();
            # TRUE: Deletou a tupla com o id requisitado => 200
            # FALSE: Não existia nenhuma tupla com o id requisitado => 204
            $sucesso = $dao->deleteFuncionarioById( $args["idFuncionario"] );
            $status = ( $sucesso ) ? 200 : 204;
            if($status == 200){
                $response->write('Deletado com sucesso');
            }
        } catch (BadHttpRequest $e) {
            $status = 400;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } catch ( \PDOException $e ) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } 
        return $response->withStatus($status);
    }

    public function cadastrarFuncionario( Request $request, Response $response, array $args )
    {

        $status = 201;
        try {
                $objEntrada = $request->getParsedBody();

                var_dump($objEntrada);

            if ( is_null($objEntrada) )
                throw new BadHttpRequest();


            $arrayFuncionario = array("login"=>$objEntrada["login"],
                                "senha"=>$objEntrada["senha"]);

            $funcionarioInst = new Funcionario($arrayFuncionario);
            $dao = new FuncionarioDAO();
            $dao->createFuncionario( $funcionarioInst );

        } catch (BadHttpRequest $e) {
            $status = 400;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } catch (\PDOException $e) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        }

        return $response->withStatus($status);
    }

    # Por simplificação será preciso enviar todos os valores e o update ocorrerá no objeto inteiro.
    public function updateFuncionario( Request $request, Response $response, array $args )
    {

        $status = 200;

        try {

            # Verifica o argumento que vem via URL
            if ( isset( $args["idFuncionario"]) ) {
                if ( !is_numeric( $args["idFuncionario"] ) )
                    throw new BadHttpRequest();
            } else { 
                throw new BadHttpRequest();
            }

            $objEntrada = $request->getParsedBody();            

            if ( is_null($objEntrada) )
                throw new BadHttpRequest();

            
            if (!(isset( $objEntrada["login"] ) &&
            isset( $objEntrada["senha"]) ))

                throw new BadHttpRequest();

                    
            $arrayFuncionario = array("login"=>$objEntrada["login"],
                                "senha"=>$objEntrada["senha"]);


            $funcionarioInst = new Funcionario($arrayFuncionario);
            $dao = new FuncionarioDAO();
            $sucesso = $dao->updateFuncionarioById( $args["idFuncionario"]  , $funcionarioInst );
            $status = ( $sucesso ) ? 200 : 204;
            if($status == 200){
                $response->write('Atualizado com sucesso');
            }
        } catch (BadHttpRequest $e) {
            $status = 400;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } catch (\PDOException $e) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        }

        return $response->withStatus($status);
    }

}