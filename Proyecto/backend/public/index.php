<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

// Cargar las clases de MYAPI manualmente
require_once __DIR__ . '/../myapi/DataBase.php';
require_once __DIR__ . '/../myapi/Read/Read.php';
require_once __DIR__ . '/../myapi/Create/Create.php';
require_once __DIR__ . '/../myapi/Update/Update.php';
require_once __DIR__ . '/../myapi/Delete/Delete.php';

// Iniciar sesión para mantener estado del usuario
session_start();

$app = AppFactory::create();

// IMPORTANTE: Configurar basePath para que Slim funcione correctamente
$app->setBasePath('/tecweb/Proyecto/backend/public');

// Middleware CORS
$app->add(function (Request $request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

// Manejar OPTIONS (CORS preflight)
$app->options('/{routes:.+}', function (Request $request, Response $response) {
    return $response;
});

// ============================================
// RECURSOS - Listar todos
// ============================================
$app->get('/recursos', function (Request $request, Response $response, $args) {
    $read = new TECWEB\MYAPI\Read\Read('digital_resources_db');
    $read->list();

    $response->getBody()->write($read->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// ============================================
// RECURSOS - Buscar por query
// ============================================
$app->get('/recursos/search/{query}', function (Request $request, Response $response, array $args) {
    $search = $args['query'];

    $read = new TECWEB\MYAPI\Read\Read('digital_resources_db');
    $read->search($search);

    $response->getBody()->write($read->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// ============================================
// RECURSOS - Ver uno específico
// ============================================
$app->get('/recursos/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];

    $read = new TECWEB\MYAPI\Read\Read('digital_resources_db');
    $read->single($id);

    $response->getBody()->write($read->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// ============================================
// RECURSOS - Crear nuevo
// ============================================
$app->post('/recursos', function (Request $request, Response $response, $args) {
    $jsonOBJ = json_decode($request->getBody());

    $create = new TECWEB\MYAPI\Create\Create('digital_resources_db');
    $create->add($jsonOBJ);

    $response->getBody()->write($create->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// ============================================
// RECURSOS - Actualizar
// ============================================
$app->put('/recursos', function (Request $request, Response $response, $args) {
    $jsonOBJ = json_decode($request->getBody());

    $update = new TECWEB\MYAPI\Update\Update('digital_resources_db');
    $update->edit($jsonOBJ);

    $response->getBody()->write($update->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// ============================================
// RECURSOS - Eliminar (lógico)
// ============================================
$app->delete('/recursos/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];

    $delete = new TECWEB\MYAPI\Delete\Delete('digital_resources_db');
    $delete->delete($id);

    $response->getBody()->write($delete->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// ============================================
// REGISTRO DE USUARIO
// ============================================
$app->post('/register', function (Request $request, Response $response, $args) {
    $jsonOBJ = json_decode($request->getBody());

    $create = new TECWEB\MYAPI\Create\Create('digital_resources_db');
    $create->register_user($jsonOBJ);

    $response->getBody()->write($create->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// ============================================
// LOGIN DE USUARIO
// ============================================
$app->post('/login', function (Request $request, Response $response, $args) {
    $jsonOBJ = json_decode($request->getBody());

    $read = new TECWEB\MYAPI\Read\Read('digital_resources_db');
    $resultData = $read->login_user($jsonOBJ);

    // Si el login es exitoso, guardar en sesión
    if (isset($resultData['status']) && $resultData['status'] === 'success') {
        $_SESSION['user_id'] = $resultData['user']['id'];
        $_SESSION['username'] = $resultData['user']['username'];
        $_SESSION['email'] = $resultData['user']['email'];
    }

    $response->getBody()->write(json_encode($resultData));
    return $response->withHeader('Content-Type', 'application/json');
});

// ============================================
// LOGOUT
// ============================================
$app->post('/logout', function (Request $request, Response $response, $args) {
    session_destroy();
    
    $data = [
        'status' => 'success',
        'message' => 'Sesión cerrada correctamente'
    ];
    
    $response->getBody()->write(json_encode($data));
    return $response->withHeader('Content-Type', 'application/json');
});

// ============================================
// VERIFICAR SESIÓN
// ============================================
$app->get('/check_session', function (Request $request, Response $response, $args) {
    if (isset($_SESSION['user_id'])) {
        $data = [
            'status' => 'success',
            'message' => 'Sesión activa',
            'user' => [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
                'email' => $_SESSION['email']
            ]
        ];
    } else {
        $data = [
            'status' => 'error',
            'message' => 'Sin sesión activa'
        ];
    }
    
    $response->getBody()->write(json_encode($data));
    return $response->withHeader('Content-Type', 'application/json');
});

// ============================================
// DESCARGAR ARCHIVO
// ============================================
$app->get('/download/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    
    // Obtener información del recurso
    $read = new TECWEB\MYAPI\Read\Read('digital_resources_db');
    $read->single($id);
    $data = json_decode($read->getData(), true);
    
    if (!empty($data) && isset($data['archivo'])) {
        $filePath = __DIR__ . '/../uploads/' . $data['archivo'];
        
        if (file_exists($filePath)) {
            // Registrar descarga si hay sesión activa
            if (isset($_SESSION['user_id'])) {
                // Aquí podrías registrar en download_log
            }
            
            // Enviar archivo
            $fileContent = file_get_contents($filePath);
            $response->getBody()->write($fileContent);
            
            return $response
                ->withHeader('Content-Type', 'application/octet-stream')
                ->withHeader('Content-Disposition', 'attachment; filename="' . basename($data['archivo']) . '"')
                ->withHeader('Content-Length', filesize($filePath));
        }
    }
    
    $error = [
        'status' => 'error',
        'message' => 'Archivo no encontrado'
    ];
    $response->getBody()->write(json_encode($error));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});

$app->run();
?>