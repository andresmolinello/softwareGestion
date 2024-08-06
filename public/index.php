<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/db.php';
require __DIR__ . '/../src/Controllers/AdvisoryTypeController.php';
require __DIR__ . '/../src/Repositories/AdvisoryTypeRepository.php';
require __DIR__ . '/../src/Controllers/ActivityTypeController.php';
require __DIR__ . '/../src/Repositories/ActivityTypeRepository.php';

// Crear la aplicación Slim
$app = AppFactory::create();

// Middleware para JSON
$app->addBodyParsingMiddleware();

// Crear instancia del repositorio y del controlador
$advisoryTypeController = new \App\Controllers\AdvisoryTypeController(
    new \App\Repositories\AdvisoryTypeRepository()
);

$activityTypeController = new \App\Controllers\ActivityTypeController(
    new \App\Repositories\ActivityTypeRepository()
);

// Rutas AdvisoryType
$app->get('/api/advisorytypes', [$advisoryTypeController, 'getAll']);
$app->get('/api/advisorytypes/{id}', [$advisoryTypeController, 'getById']);
$app->post('/api/advisorytypes', [$advisoryTypeController, 'create']);
$app->put('/api/advisorytypes/{id}', [$advisoryTypeController, 'update']);
$app->patch('/api/advisorytypes/{id}', [$advisoryTypeController, 'partialUpdate']);
$app->delete('/api/advisorytypes/{id}', [$advisoryTypeController, 'delete']);

//Rutas ActivityType

$app->get('/api/activitytypes', [$activityTypeController, 'getAll']);
$app->get('/api/activitytypes/{id}', [$activityTypeController, 'getById']);
$app->post('/api/activitytypes', [$activityTypeController, 'create']);
$app->put('/api/activitytypes/{id}', [$activityTypeController, 'update']);
$app->patch('/api/activitytypes/{id}', [$activityTypeController, 'partialUpdate']);
$app->delete('/api/activitytypes/{id}', [$activityTypeController, 'delete']);



// Ejecutar la aplicación
$app->run();
