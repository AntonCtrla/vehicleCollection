<?php

namespace VehicleCollection\Controllers;

use VehicleCollection\Models\VehicleModel;
use VehicleCollection\Models\VehicleModelInterface;
use VehicleCollection\Views\View;

class TableController
{
    private View $view;
    private VehicleModel $vehicleModel;

    public function __construct(View $view, VehicleModelInterface $vehicleModel)
    {
        $this->view = $view;
        $this->vehicleModel = $vehicleModel;
    }

    /**
     * @description Called from Router by callback
     * @return void
     */
    public function showTable(): void
    {
        $vehicles = $this->vehicleModel->getAllVehicles();
        $this->view->set('vehicles', $vehicles);
        $this->view->render();
    }
}
