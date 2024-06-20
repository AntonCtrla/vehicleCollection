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

    public function runSumm($a, $b): string {
        $lengthA = strlen($a);
        $lengthB = strlen($b);

        $sum = 0;
        $maxLength = max($lengthA, $lengthB);

        $a = str_pad($a, $maxLength,"0", STR_PAD_LEFT);
        $b = str_pad($b, $maxLength,"0", STR_PAD_LEFT);

        $result = '';
        $division = 0;
        for ($i = $maxLength-1; $i >= 0; $i--) {

            $sum = $division + intval($a[$i]) + intval($b[$i]);
            $division = intdiv($sum,10);
            $result = ($sum%10) . $result;
        }

        return $result;
    }

    public function fibonacciSeq(int $n): ?string {
        $trace = '';

        if ($n<0) return '';
        $trace .= __FUNCTION__.': '.PHP_EOL;

        $res = [];

        for ($i=0; $i<$n; $i++) {
            // working around the limits
            if (($res[$i-1]??0) >= PHP_INT_MAX) { return 'Error max int: '.PHP_INT_MAX.''; }

            $trace .= 'i['.$i.']';

            if ($i == 0) { $res[$i] = 0;}
            else if ($i == 1) { $res[$i] = 1;}
            else $res[$i] = $res[$i-1] + $res[$i-2];

            $trace .= '='.$res[$i];
            if ($i > 1) {
                $trace .= " :: ($i-1)=" . $res[$i - 1] . " + ($i-2)=" . $res[$i - 2] . PHP_EOL;
            } else{
                $trace .= PHP_EOL;
            }

        }
        $trace .= PHP_EOL;

        return array_pop($res);
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