<?php

namespace app\controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use app\model\QuartoDAOImplementation as QuartoDAO;
use app\classes\BadHttpRequest;
use app\classes\Quarto;


class ControladorApp
{
    ////////////////////////////////////// QUARTO ///////////////////////////////////
    public function lerTodosQuartos( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            $dao = new QuartoDAO();
            $quartosArray = $dao->getAllQuartos();

            $corpoResp =  json_encode( array( "quarto" =>$quartosArray ) );
            $response = $response->withHeader('Content-type', 'application/json')
                                 ->write( $corpoResp );
        } catch ( \PDOException $e ) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } 
        return $response->withStatus($status);
    }

    public function lerQuarto( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            # Verifica o argumento que vem via URL
            if ( isset( $args["idQuarto"]) ) {
                if ( !is_numeric( $args["idQuarto"] ) )
                    throw new BadHttpRequest();
            } else { 
                throw new BadHttpRequest();
            }

            $dao = new QuartoDAO();
            $quarto = $dao->getQuartoById( $args["idQuarto"] );

            $status = ( !is_null( $quarto ) ) ? 200 : 204; 

            $corpoResp =  json_encode( $quarto );
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

    public function deletarQuarto( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            # Verifica o argumento que vem via URL
            if ( isset( $args["idQuarto"]) ) {
                if ( !is_numeric( $args["idQuarto"] ) )
                    throw new BadHttpRequest();
            } else { 
                throw new BadHttpRequest();
            }

            $dao = new QuartoDAO();
            # TRUE: Deletou a tupla com o id requisitado => 200
            # FALSE: Não existia nenhuma tupla com o id requisitado => 204
            $sucesso = $dao->deleteQuartoById( $args["idQuarto"] );
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

    public function cadastrarQuarto( Request $request, Response $response, array $args )
    {

        $status = 201;
        try {
                $objEntrada = $request->getParsedBody();

                var_dump($objEntrada);

            if ( is_null($objEntrada) )
                throw new BadHttpRequest();


            $arrayQuarto = array( "capacidade"=>$objEntrada["capacidade"],
                                "descricao"=>$objEntrada["descricao"],
                                "precoDia"=>$objEntrada["precoDia"],
                                "nomeQuarto"=>$objEntrada["nomeQuarto"]);

            $quartoInst = new Quarto($arrayQuarto);
            $dao = new QuartoDAO();
            $dao->createQuarto( $quartoInst );

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
    public function updateQuarto( Request $request, Response $response, array $args )
    {

        $status = 200;

        try {

            # Verifica o argumento que vem via URL
            if ( isset( $args["idQuarto"]) ) {
                if ( !is_numeric( $args["idQuarto"] ) )
                    throw new BadHttpRequest();
            } else { 
                throw new BadHttpRequest();
            }

            $objEntrada = $request->getParsedBody();            

            if ( is_null($objEntrada) )
                throw new BadHttpRequest();

            
            if (!( isset( $objEntrada["capacidade"] ) &&
            isset( $objEntrada["descricao"] ) &&
            isset( $objEntrada["precoDia"]) &&
            isset($objEntrada["nomeQuarto"]) ))

                throw new BadHttpRequest();

                    
            $arrayQuarto = array( "capacidade"=>$objEntrada["capacidade"],
            "descricao"=>$objEntrada["descricao"],
            "precoDia"=>$objEntrada["precoDia"],
            "nomeQuarto"=>$objEntrada["nomeQuarto"]);


            $quartoInst = new Quarto($arrayQuarto);
            $dao = new QuartoDAO();
            $sucesso = $dao->updateQuartoById( $args["idQuarto"]  , $quartoInst );
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