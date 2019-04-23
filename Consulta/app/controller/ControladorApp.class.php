<?php

namespace app\controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use app\model\ClienteDAOImplementation as ClienteDAO;
use app\model\QuartoDAOImplementation as QuartoDAO;
use app\model\FuncionarioDAOImplementation as FuncionarioDAO;
use app\model\ReservaDAOImplementation as ReservaDAO;
use app\classes\BadHttpRequest;
use app\classes\Cliente;
use app\classes\Quarto;
use app\classes\Funcionario;
use app\classes\Reserva;

class ControladorApp
{
    //  CLIENTEEEEEEEEEEE
    public function lerTodosClientes( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            $dao = new ClienteDAO();
            $clientesArray = $dao->getAllClientes();

            $corpoResp =  json_encode( array( "cliente" =>$clientesArray ) );
            $response = $response->withHeader('Content-type', 'application/json')
                                 ->write( $corpoResp );
        } catch ( \PDOException $e ) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } 
        return $response->withStatus($status);
    }

    public function lerCliente( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            # Verifica o argumento que vem via URL
            if ( isset( $args["idCliente"]) ) {
                if ( !is_numeric( $args["idCliente"] ) )
                    throw new BadHttpRequest();
            } else { 
                throw new BadHttpRequest();
            }

            $dao = new ClienteDAO();
            $cliente = $dao->getClienteById( $args["idCliente"] );

            $status = ( !is_null( $cliente ) ) ? 200 : 204; 

            $corpoResp =  json_encode( $cliente );
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

    public function deletarCliente( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            # Verifica o argumento que vem via URL
            if ( isset( $args["idCliente"]) ) {
                if ( !is_numeric( $args["idCliente"] ) )
                    throw new BadHttpRequest();
            } else { 
                throw new BadHttpRequest();
            }

            $dao = new ClienteDAO();
            # TRUE: Deletou a tupla com o id requisitado => 200
            # FALSE: Não existia nenhuma tupla com o id requisitado => 204
            $sucesso = $dao->deleteClienteById( $args["idCliente"] );
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

    public function cadastrarCliente( Request $request, Response $response, array $args )
    {

        $status = 201;
        try {
                $objEntrada = $request->getParsedBody();

                var_dump($objEntrada);

            if ( is_null($objEntrada) )
                throw new BadHttpRequest();


            $arrayCliente = array( "nome"=>$objEntrada["nome"],
                                "telefone"=>$objEntrada["telefone"],
                                "cpf"=>$objEntrada["cpf"],
                                "endereco"=>$objEntrada["endereco"],
                                "email"=> $objEntrada["email"],
                                "senha"=> $objEntrada["senha"]);

            $clienteInst = new Cliente($arrayCliente);
            $dao = new ClienteDAO();
            $dao->createCliente( $clienteInst );

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
    public function updateCliente( Request $request, Response $response, array $args )
    {

        $status = 200;

        try {

            # Verifica o argumento que vem via URL
            if ( isset( $args["idCliente"]) ) {
                if ( !is_numeric( $args["idCliente"] ) )
                    throw new BadHttpRequest();
            } else { 
                throw new BadHttpRequest();
            }

            $objEntrada = $request->getParsedBody();            

            if ( is_null($objEntrada) )
                throw new BadHttpRequest();

            
            if (!( isset( $objEntrada["nome"] ) &&
            isset( $objEntrada["telefone"] ) &&
            isset( $objEntrada["cpf"]) &&
            isset($objEntrada["endereco"]) &&
            isset($objEntrada["email"]) &&
            isset($objEntrada["senha"]) ))

                throw new BadHttpRequest();

                    
            $arrayCliente = array( "nome"=>$objEntrada["nome"],
                                "telefone"=>$objEntrada["telefone"],
                                "cpf"=>$objEntrada["cpf"],
                                "endereco"=>$objEntrada["endereco"],
                                "email"=> $objEntrada["email"],
                                "senha"=> $objEntrada["senha"]);


            $clienteInst = new Cliente($arrayCliente);
            $dao = new ClienteDAO();
            $sucesso = $dao->updateClienteById( $args["idCliente"]  , $clienteInst );
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

    //  FUNCIONARIOOOOOOOOOOOOO

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

            
            if (!( isset( $objEntrada["nome"] ) &&
            isset( $objEntrada["login"] ) &&
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


    //QUARTOOOOOOOOOOOOOOO
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



    //RESERVAAAAAAAAAAAAAAAAAAA

    public function lerTodosReservas( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            $dao = new ReservaDAO();
            $reservasArray = $dao->getAllReservas();

            $corpoResp =  json_encode( array( "reserva" =>$reservasArray ) );
            $response = $response->withHeader('Content-type', 'application/json')
                                 ->write( $corpoResp );
        } catch ( \PDOException $e ) {
            $status = 500;
            $response->write('Exceção capturada: '.  $e->getMessage(). '\n');
        } 
        return $response->withStatus($status);
    }

    public function lerReserva( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            # Verifica o argumento que vem via URL
            if ( isset( $args["idReserva"]) ) {
                if ( !is_numeric( $args["idReserva"] ) )
                    throw new BadHttpRequest();
            } else { 
                throw new BadHttpRequest();
            }

            $dao = new ReservaDAO();
            $reserva = $dao->getReservaById( $args["idReserva"] );

            $status = ( !is_null( $reserva ) ) ? 200 : 204; 

            $corpoResp =  json_encode( $reserva );
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

    public function deletarReserva( Request $request, Response $response, array $args )
    {
        $status = 200;

        try {
            # Verifica o argumento que vem via URL
            if ( isset( $args["idReserva"]) ) {
                if ( !is_numeric( $args["idReserva"] ) )
                    throw new BadHttpRequest();
            } else { 
                throw new BadHttpRequest();
            }

            $dao = new ReservaDAO();
            # TRUE: Deletou a tupla com o id requisitado => 200
            # FALSE: Não existia nenhuma tupla com o id requisitado => 204
            $sucesso = $dao->deleteReservaById( $args["idReserva"] );
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

    public function cadastrarReserva( Request $request, Response $response, array $args )
    {

        $status = 201;
        try {
                $objEntrada = $request->getParsedBody();

                var_dump($objEntrada);

            if ( is_null($objEntrada) )
                throw new BadHttpRequest();

            $arrayReserva = array("idQuartoReserva"=>$objEntrada["idQuartoReserva"],
                                "dataDia"=>$objEntrada["dataDia"],
                                "dataMes"=> $objEntrada["dataMes"],
                                "dataAno"=> $objEntrada["dataAno"],
                                "qntDias"=> $objEntrada["qntDias"] );

            $reservaInst = new Reserva($arrayReserva);
            $dao = new ReservaDAO();
            $dao->createReserva( $reservaInst, $objEntrada["idQuartoReserva"] , $objEntrada["cpf"] );

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
    public function updateReserva( Request $request, Response $response, array $args )
    {

        $status = 200;

        try {

            # Verifica o argumento que vem via URL
            if ( isset( $args["idReserva"]) ) {
                if ( !is_numeric( $args["idReserva"] ) )
                    throw new BadHttpRequest();
            } else { 
                throw new BadHttpRequest();
            }

            $objEntrada = $request->getParsedBody();            

            if ( is_null($objEntrada) )
                throw new BadHttpRequest();

            
            if (!(isset($objEntrada["idQuartoReserva"])&&
                  isset( $objEntrada["dataDia"]) &&
                  isset($objEntrada["dataMes"]) &&
                  isset($objEntrada["dataAno"]) &&
                  isset($objEntrada["qntDias"]) ))

                throw new BadHttpRequest();

                    
            $arrayReserva = array( "idQuartoReserva"=>$objEntrada["idQuartoReserva"],
                                   "dataDia"=>$objEntrada["dataDia"],
                                   "dataMes"=> $objEntrada["dataMes"],
                                   "dataAno"=> $objEntrada["dataAno"],
                                   "qntDias"=> $objEntrada["qntDias"]);


            $reservaInst = new Reserva($arrayReserva);
            $dao = new ReservaDAO();
            $sucesso = $dao->updateReservaById( $args["idReserva"]  , $reservaInst, $objEntrada["idQuartoReserva"] , $objEntrada["cpf"]  );
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