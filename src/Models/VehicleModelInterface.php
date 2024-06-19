<?php

namespace VehicleCollection\Models;

interface VehicleModelInterface
{
    public function insertVehicle($brand, $country, $fuel, $gearbox, $power, $mileage);
    public function getAllVehicles();
}
