<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \app\controller\ControladorApp;
use \app\classes\Funcionario;
use \app\model\FuncionarioDAOImplementation as FuncionarioDAO;

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
        
    //////////////////////////////////////// FUNCIONARIO ////////////////////////////////////////

    //Cadastrar um funcionário
    $this->post('/funcionario'  , function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->cadastrarFuncionario($request, $response, $args);
    });

    //Acessar todos dados dos funcionarios cadastrados
    $this->get('/funcionario', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->lerTodosFuncionarios($request, $response, $args);
    });

    //Acessar os dados de um funcionario específico pelo Id
    $this->get('/funcionario/{idFuncionario}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->lerFuncionario($request, $response, $args);
    });

    //Deletar um funcionario pelo Id
    $this->delete('/funcionario/{idFuncionario}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->deletarFuncionario($request, $response, $args);
    });

    //Atualizar informações de um funcionario cadastrado pelo Id
    $this->put('/funcionario/{idFuncionario}', function (Request $request, Response $response, array $args) {
        $controlador = new ControladorApp();
        return $controlador->updateFuncionario($request, $response, $args);
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