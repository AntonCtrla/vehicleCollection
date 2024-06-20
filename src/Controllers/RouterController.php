<?php

namespace VehicleCollection\Controllers;

use VehicleCollection\Models\CollectModel;
use VehicleCollection\Models\Database;
use VehicleCollection\Models\HomeModel;
use VehicleCollection\Models\VehicleModel;
use VehicleCollection\Views\View;

class RouterController
{
    protected $routes = [];

    private $homeController;
    private $collectController;
    private $tableController;

    public function __construct()
    {
        $pdo = Database::getInstance()->getPdo();

        $viewHome = new View('home');
        $viewCollect = new View('collect');
        $viewTable = new View('table');

        $vehicleModel = new VehicleModel($pdo);
        $collectModel = new CollectModel();

        $homeModel = new HomeModel($pdo);

        $this->homeController = new HomeController($viewHome, $homeModel);
        $this->collectController = new CollectController($viewCollect, $collectModel, $vehicleModel);
        $this->tableController = new TableController($viewTable, $vehicleModel);
    }

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
        $path = rtrim($path, '/'); // Remove trailing slash
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        // Redirect root URL to index route
        if ($path === '') {
            $path = '/';
        }

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            http_response_code(404);
            echo "404 Not Found";
            exit;
        }

        if (is_array($callback)) {
            $controllerName = $callback[0];
            $methodName = $callback[1];

            if (!property_exists($this, $controllerName)) {
                http_response_code(500);
                echo "Controller not found: $controllerName";
                exit;
            }

            $controller = $this->$controllerName;
            $this->callMethod($controller, $methodName);
        } else {
            http_response_code(500);
            echo "Invalid callback";
        }
    }

    protected function callMethod($controller, $methodName)
    {
        try {
            $reflectionMethod = new \ReflectionMethod($controller, $methodName);
            $reflectionMethod->invoke($controller);
        } catch (\ReflectionException $e) {
            http_response_code(500);
            echo "Method not found: $methodName";
        }
    }

    public function main()
    {
        $this->get('/', ['homeController', 'index']);


        $this->get('/fibo', ['homeController','fibonacci']);
        $this->get('/summ', ['homeController','summ']);
        $this->post('/fibo', ['homeController','fibonacci']);
        $this->post('/summ', ['homeController','summ']);


        $this->get('/collect', ['collectController', 'showForm']);

        $this->post('/collectids', ['collectController', 'collectIDData']);
        $this->post('/savevehicle', ['collectController', 'collectVehicleData']);
        $this->get('/table', ['tableController', 'showTable']);

        $this->resolve();
    }
}
