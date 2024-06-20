<?php

namespace VehicleCollection\Controllers;

use VehicleCollection\Models\CollectModel;
use VehicleCollection\Models\VehicleModel;
use VehicleCollection\Views\View;

class CollectController
{
    private View $view;
    private collectModel $collectModel;
    private vehicleModel $vehicleModel;

    public function __construct(View $view, CollectModel $collectModel, VehicleModel $vehicleModel)
    {
        $this->view = $view;
        $this->collectModel = $collectModel;
        $this->vehicleModel = $vehicleModel;
    }

    /**
     * @description retrieveing from Router
     * @return void
     */
    public function showForm(): void
    {
        $this->view->set('apiEndpoint', $_ENV['API_ENDPOINT']);
        $this->view->render();
    }

    /**
     * @description for local AJAX. Parses car ids and echoes them to frontend.
     * @return void
     */
    public function collectIDData(): void
    {
        $message = '';

        $data = json_decode(file_get_contents('php://input'), true);
        $message .= '';
        $parsedCarIds = $this->collectModel->parseCarIdsFromResponse($data);

        $requested = count($parsedCarIds);
        $exists = 0;

        foreach ($parsedCarIds as $k => $carId) {
            if ($this->vehicleModel->isVehicleExists($carId)) {
                $exists++;
                unset($parsedCarIds[$k]);
            }
        }

        $message .= 'Requested <b>'.$requested.'</b> 
        | To retrieve: <b class="text-info">'.count($parsedCarIds). '</b>
        | Already exists: <b class="text-warning">'.$exists.'</b>';

        echo json_encode(['message' => $message, 'carIds' => array_values($parsedCarIds)]);
    }

    /**
     * @description for local AJAX.Tries to parse it and return to frontend
     * @return void
     */
    public function collectVehicleData():void {
        $message = '';

        $params = json_decode(file_get_contents('php://input'), true);
        // first iteration of the data formatting from the json/html
        $carDetailsRaw = $this->collectModel->retrieveVehicleDataFromJson($params);

        if (!is_array($carDetailsRaw) || count($carDetailsRaw) == 0) {
            $message .= '<p class="text-error">Car details are missing</p>';
        }

        // formatting data into needed format
        $data = $formattedVehicleData = $this->collectModel->mapParsedDataAboutVehicle($carDetailsRaw);

        $remoteId = $formattedVehicleData['remoteId'] ?? false;
        if ($this->vehicleModel->isVehicleExists($remoteId)) {
            $message .= '<p class="text-warning">Skipping: Vehicle exists</p>';
        } else if ($this->vehicleModel->insertVehicle($formattedVehicleData)) {
            $message .= '<p class="text-success">Vehicle with inserted to db</p>';
        } else {
            $message .= '<p class="text-danger">Vehicle insertion failed</p>';
        }

        $result = ['message' => $message, 'data' => false];

        echo json_encode($result);
    }


}
