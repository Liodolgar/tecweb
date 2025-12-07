<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/recursos', function (Request $request, Response $response, $args) {
    $read = new TECWEB\MYAPI\Read\Read('digital_resources');
    $read->list();

    $response->getBody()->write($read->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/recursos/search/{query}', function (Request $request, Response $response, array $args) {
    $search = $args['query'];

    $read = new TECWEB\MYAPI\Read\Read('digital_resources');
    $read->search($search);

    $response->getBody()->write($read->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/recursos/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];

    $read = new TECWEB\MYAPI\Read\Read('digital_resources');
    $read->single($id);

    $response->getBody()->write($read->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/recursos', function (Request $request, Response $response, $args) {
    $jsonOBJ = json_decode($request->getBody());

    $create = new TECWEB\MYAPI\Create\Create('digital_resources');
    $create->add($jsonOBJ);

    $response->getBody()->write($create->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

$app->put('/recursos', function (Request $request, Response $response, $args) {
    $jsonOBJ = json_decode($request->getBody());

    $update = new TECWEB\MYAPI\Update\Update('digital_resources');
    $update->edit($jsonOBJ);

    $response->getBody()->write($update->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

$app->delete('/recursos/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];

    $delete = new TECWEB\MYAPI\Delete\Delete('digital_resources');
    $delete->delete($id);

    $response->getBody()->write($delete->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/register', function (Request $request, Response $response, $args) {
    $jsonOBJ = json_decode($request->getBody());

    $create = new TECWEB\MYAPI\Create\Create('digital_resources');
    $create->register_user($jsonOBJ);

    $response->getBody()->write($create->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/login', function (Request $request, Response $response, $args) {
    $jsonOBJ = json_decode($request->getBody());

    $read = new TECWEB\MYAPI\Read\Read('digital_resources');
    $read->login_user($jsonOBJ);

    $response->getBody()->write($read->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
