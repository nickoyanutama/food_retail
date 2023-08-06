<?php

require_once __DIR__ . '/vendor/autoload.php';

use FoodRetail\App\Router;
use FoodRetail\Controller\HomeController;
use FoodRetail\Controller\ProductController;

Router::add('GET', '/', HomeController::class, 'index');
Router::add('GET', '/api', HomeController::class, 'api');

Router::add('GET', '/api/product', ProductController::class, 'index');
Router::add('GET', '/api/product/show', ProductController::class, 'show');
Router::add('POST', '/api/product/create', ProductController::class, 'create');
Router::add('PUT', '/api/product/update', ProductController::class, 'update');
Router::add('DELETE', '/api/product/delete', ProductController::class, 'softDelete');
Router::add('PUT', '/api/product/restore', ProductController::class, 'restore');

Router::run();
