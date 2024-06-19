<?php

namespace VehicleCollection\Models;

use PDO;

class VehicleModel implements VehicleModelInterface
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function isVehicleExists($remoteId)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM vehicle WHERE remoteId = ?");
        $stmt->execute([$remoteId]);
        return $stmt->fetch() !== false;
    }

    /**
     * @param array $vehicleData = {
     * "remoteId":3846476,
     * "title":"Mercedes GLE 350",
     * "brand"
     * "model"
     * "mileage":"60883",
     * "co2_value":"342",
     * "gearbox":"Automatic",
     * "fuel":"Hybrid (petrol / electric)",
     * "emission_class":"Euro6",
     * "country":"belgium",
     * "engine_size":"1991 cc",
     * "first_registration":"2021-01-01 17:37:33",
     * "power":"155"
     * }
     * @return void
     */
    public function insertVehicle(array $vehicleData): bool
    {
        $remoteId = $vehicleData['remoteId']??false;
        if (!$remoteId) return false;
        $title = $vehicleData['title'] ?? 'N/A';
        $brand = $vehicleData['brand'] ?? 'N/A';
        $model = $vehicleData['model'] ?? 'N/A';
        $country = $vehicleData['country'] ?? 'N/A';
        $fuel = $vehicleData['fuel'] ?? 'N/A';
        $gearbox = $vehicleData['gearbox'] ?? 'N/A';
        $firstRegistration = $vehicleData['first_registration'] ?? 'N/A';
        $mileage = $vehicleData['mileage'] ?? 0;
        $engineSize = $vehicleData['engine_size'] ?? 0;
        $power = $vehicleData['power'] ?? 0;
        $emissionClass = $vehicleData['emission_class'] ?? 'N/A';
        $co2_value = $vehicleData['co2_value'] ?? '0';

        $brandId = $this->getOrCreateId('brand', 'name', $brand);
        $countryId = $this->getOrCreateId('country', 'name', $country);
        $fuelId = $this->getOrCreateId('fuel', 'name', $fuel);
        $gearboxId = $this->getOrCreateId('gearbox', 'name', $gearbox);

        // id | remoteId | title |brand_id | model | first_registration | mileage | gearbox_id | fuel_id | engine_size | power | emission_class | co2_value | country_id

        $db = $this->pdo->prepare("INSERT INTO vehicle 
            (remoteId, title, brand_id, model, first_registration, mileage, gearbox_id, fuel_id, engine_size, power, emission_class, co2_value, country_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $db->execute([$remoteId, $title, $brandId, $model, $firstRegistration, $mileage,$gearboxId, $fuelId, $engineSize, $power, $emissionClass, $co2_value, $countryId]);

    }

    public function getAllVehicles()
    {
        $db = $this->pdo->query("
            SELECT v.id, b.name AS brand, c.name AS country, f.name AS fuel, g.name AS gearbox, v.power, v.mileage
            FROM vehicle v
            JOIN brand b ON v.brand_id = b.id
            JOIN country c ON v.country_id = c.id
            JOIN fuel f ON v.fuel_id = f.id
            JOIN gearbox g ON v.gearbox_id = g.id
        ");
        return $db->fetchAll();
    }

    private function getOrCreateId($table, $column, $value)
    {
        $db = $this->pdo->prepare("SELECT id FROM $table WHERE $column = ?");
        $db->execute([$value]);
        $row = $db->fetch();

        if ($row) {
            return $row['id'];
        } else {
            $db = $this->pdo->prepare("INSERT INTO $table ($column) VALUES (?)");
            $db->execute([$value]);
            return $this->pdo->lastInsertId();
        }
    }



}
