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
    
   
    ////////////////////////////////////////QUARTO///////////////////////////////////////

    //Cadastrar um quarto
    $this->post('/quarto', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->cadastrarQuarto($request, $response, $args);
    });

    //Acessar todos dados dos quartos cadastrados
    $this->get('/quarto', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->lerTodosQuartos($request, $response, $args);
    });

    //Acessar os dados de um quarto específico pelo Id
    $this->get('/quarto/{idQuarto}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->lerQuarto($request, $response, $args);
    });

    //Deletar um quarto pelo Id
    $this->delete('/quarto/{idQuarto}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->deletarQuarto($request, $response, $args);
    });

    //Atualizar informações de um quarto cadastrado pelo Id
    $this->put('/quarto/{idQuarto}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->updateQuarto($request, $response, $args);
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