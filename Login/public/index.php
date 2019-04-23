<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \app\controller\ControladorApp;
use \app\classes\Cliente;
use \app\model\ClienteDAOImplementation as ClienteDAO;

require_once 'config.php';

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');


$app = new \Slim\App;

# Desabilita tratamento automatico de exceção do Slim, as execeções são tratados
# pela aplicação no controller (ControllerApp), em que os HTTP status code são configurados
# corretamente para resposta.
$c = $app->getContainer();
unset($c['phpErrorHandler']);

# ROTAS
$app->group('/v1',function ( ) {
    $this->get('/hello/{name}', function (Request $request, Response $response, array $args) {
           
        return $response->write($args["name"])->withStatus(201);
    });

    $this->post('/cliente', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->cadastrarCliente($request, $response, $args);
    });

    $this->get('/cliente', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->lerTodosClientes($request, $response, $args);
    });

    $this->get('/cliente/{idCliente}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->lerCliente($request, $response, $args);
    });
    
    $this->delete('/cliente/{idCliente}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->deletarCliente($request, $response, $args);
    });

    $this->put('/cliente/{idCliente}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->updateCliente($request, $response, $args);
    });


    //FUNCIONARIOOOOOOOO

    $this->post('/funcionario'  , function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->cadastrarFuncionario($request, $response, $args);
    });

    $this->get('/funcionario', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->lerTodosFuncionarios($request, $response, $args);
    });

    $this->get('/funcionario/{idFuncionario}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->lerFuncionario($request, $response, $args);
    });
    
    $this->delete('/funcionario/{idFuncionario}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->deletarFuncionario($request, $response, $args);
    });

    $this->put('/funcionario/{idFuncionario}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->updateFuncionario($request, $response, $args);
    });

    //Q U A R T O O O O O O 

    $this->post('/quarto', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->cadastrarQuarto($request, $response, $args);
    });

    $this->get('/quarto', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->lerTodosQuartos($request, $response, $args);
    });

    $this->get('/quarto/{idQuarto}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->lerQuarto($request, $response, $args);
    });
    
    $this->delete('/quarto/{idQuarto}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->deletarQuarto($request, $response, $args);
    });

    $this->put('/quarto/{idQuarto}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->updateQuarto($request, $response, $args);
    });

    // RESERVAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA

    $this->post('/reserva', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->cadastrarReserva($request, $response, $args);
    });

    $this->get('/reserva', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->lerTodosReservas($request, $response, $args);
    });

    $this->get('/reserva/{idReserva}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->lerReserva($request, $response, $args);
    });
    
    $this->delete('/reserva/{idReserva}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->deletarReserva($request, $response, $args);
    });

    $this->put('/reserva/{idReserva}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->updateReserva($request, $response, $args);
    });

});

# Criando uma função especifica para o Erro 404 "not found". Por padrão é enviado um
# html com um texto padrão. Por se tratar de uma API, irei devolver apenas o status code
# 404 sem nenhum corpo na mensagem
$c['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $response->withStatus(404);
    };
};

$app->run();