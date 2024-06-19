<?php

namespace VehicleCollection\Controllers;

use VehicleCollection\Models\VehicleModel;
use VehicleCollection\View;
use VehicleCollection\Models\VehicleModelInterface;

class TableController
{
    private $view;
    private VehicleModel $vehicleModel;

    public function __construct(View $view, VehicleModelInterface $vehicleModel)
    {
        $this->view = $view;
        $this->vehicleModel = $vehicleModel;
    }

    public function showTable()
    {
        $vehicles = $this->vehicleModel->getAllVehicles();
        $this->view->set('vehicles', $vehicles);
        $this->view->render();
    }
}
