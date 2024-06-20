<?php

namespace VehicleCollection\Models;

interface VehicleModelInterface
{
    public function insertVehicle(array $vehicleData);
    public function getAllVehicles();
    public function isVehicleExists($remoteId);

}
