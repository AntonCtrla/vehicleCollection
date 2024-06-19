<?php

namespace VehicleCollection\Models;

use PDO;

class HomeModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function milageStats(): ?array {
        $db = $this->pdo->query("SELECT AVG(mileage) AS average_mileage FROM vehicle;");
        return $db->fetchAll();
    }

    public function topCountriesStats(): ?array {
        $db = $this->pdo->query("SELECT c.name AS country, COUNT(v.id) AS vehicle_count
            FROM vehicle v
            JOIN country c ON v.country_id = c.id
            GROUP BY c.name
            ORDER BY vehicle_count DESC
        LIMIT 3;");
        return $db->fetchAll();
    }

    public function maxMinPowerStats(): ?array {
        $db = $this->pdo->query("SELECT 
                MAX(power) AS max_power_kw,
                MIN(power) AS min_power_kw,
                MAX(power * 1.34102) AS max_power_hp,
                MIN(power * 1.34102) AS min_power_hp
            FROM vehicle;
        ");
        return $db->fetchAll();
    }
    public function allGearbox(): ?array {
        $db = $this->pdo->query("SELECT name FROM gearbox ORDER BY name ASC;");
        return $db->fetchAll();
    }

    public function allFuel(): ?array {
        $db = $this->pdo->query("SELECT name FROM fuel ORDER BY name ASC;");
        return $db->fetchAll();
    }
}