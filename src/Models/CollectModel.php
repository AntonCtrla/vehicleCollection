<?php

namespace VehicleCollection\Models;

use DOMDocument;
use DOMXPath;

class CollectModel
{

    /**
     * Example Array
     * (
     * [First registration date] => 02/2010
     * [Mileage] => 87 000 KM
     * [Gearbox] => Automatic
     * [Fuel] => Diesel
     * [Engine size] => 2148 cc
     * [Power] => 136 Hp (100 kW)
     * [Emission Class] => Euro4
     * [COâ  ] => 173 CO2
     * [Sign in to see the appraisal] =>
     * [Video] =>
     * [At eCarsTrade Warehouse Overijse ] =>
     * [Country of origin: Belgium] =>
     * [] => M
     * [At eCarsTrade Warehouse] => Our Stock
     * [Car location] =>
     * )
     *
     * @param string $html
     * @param int $carId
     * @return array
     */
    private function vehicleHtmlDetailsToArray(string $html, int $carId): array
    {

        $dom = new DOMDocument;
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);
        $carData = [];

        $detailsNodes = $xpath->query('//*[@data-original-title]');

        foreach ($detailsNodes as $node) {
            $key = $node->getAttribute('data-original-title');
            $value = trim($node->textContent);
            $cleanKey = strtolower(preg_replace('/[^a-zA-Z]/', '', $key));

            $carData[$cleanKey] = $value?:$cleanKey;
        }

        // getting title
        $titleNode = $xpath->query('//div[@class="small text-muted"]')->item(0);

        $title = $titleNode ? $titleNode->nodeValue : '';
        $title = trim(str_replace('#'.$carId.' -','', $title));

        $carData['remoteId'] = $carId;
        $carData['carId'] = $carId;
        $carData['title'] = $title;

        // clearing keys
        array_walk($carData, function($value, $key) use (&$carData) {
            // Remove all non-alphabet characters from the key
            $cleanKey = preg_replace('/[^a-zA-Z]/', '', $key);
            if (str_contains($cleanKey, 'countryoforigin') !== false) {
                $value = str_replace("countryoforigin","", $cleanKey);
                $cleanKey = 'country';
            }
            $carData[$cleanKey] = $value;
        });

        if (!array_key_exists('country', $carData)) {
            $carData['country'] = 'N/A';
        }

        return $carData;
    }

    /**
     * @description Step 2 after retrieving data. Gathering car id ids from general request
     * @param string $responseBody
     * @return array
     */
    public function parseCarIdsFromResponse(string $responseBody): array
    {
        $carIds = [];

        // Split the response into separate JSON objects
        $jsonObjects = preg_split('/(?<=\})\s*(?=\{)/', $responseBody);
        if (is_iterable($jsonObjects)) {
            foreach ($jsonObjects as $jsonObject) {
                $data = json_decode($jsonObject, true);

                // Check if car_id is present and add it to the list
                if (isset($data['car_id'])) {
                    $carIds[] = $data['car_id'];
                }
            }
        }

        return $carIds;
    }

    /**
     *
      @description After parsing data from html it should be updated for structures
     * @param array $weakCarData
     * @return array
     */
    public function mapParsedDataAboutVehicle(array $weakCarData): array
    {
        $reformattedCarData = [];
        $reformattedCarData['remoteId'] = $weakCarData['carId'];
        $reformattedCarData['title'] = trim($weakCarData['title']);

        // getting brand and mark from title
        $firstSpacePosition = strpos($reformattedCarData['title'], ' ');
        $brand = substr($reformattedCarData['title'], 0, $firstSpacePosition);
        $model = substr($reformattedCarData['title'], $firstSpacePosition + 1);

        $reformattedCarData['brand'] = $brand;
        $reformattedCarData['model'] = $model;

        $reformattedCarData['mileage'] = $this->getFirstInteger($weakCarData['mileage']??0);
        $reformattedCarData['co2_value'] = $this->getFirstInteger($weakCarData['co']??0);
        $reformattedCarData['gearbox'] = $weakCarData['gearbox'];
        $reformattedCarData['fuel'] = $weakCarData['fuel'];
        $reformattedCarData['emission_class'] = $weakCarData['emissionclass'];
        $reformattedCarData['country'] = $weakCarData['country'];
        $reformattedCarData['engine_size'] = $this->getFirstInteger($weakCarData['enginesize']);

        $regdate = \DateTime::createFromFormat('d/m/Y', '1/'.$weakCarData['firstregistrationdate']);
        $reformattedCarData['first_registration'] = $regdate->format('Y-m-d H:i:s');

        // getting Kw part from string
        if (trim($weakCarData['power']) == 'N/A') {
            $powerKw = 0;
        } else {
            $powerKw = preg_replace('/.*\((\d+) kW\).*/', '$1', $weakCarData['power']);
        }

        $reformattedCarData['power'] = $powerKw??0;

        return $reformattedCarData;
    }

    private function getFirstInteger($str):?int {
        if (preg_match('/\d+/', $str, $matches)) {
            return $matches[0];
        }
        return null;
    }

    /**
     * @description decodes received json-response from api to encode it with base64 for html parser
     * @param string $responseBodyJson
     * @return array
     */
    public function retrieveVehicleDataFromJson(string $responseBodyJson): array {

        $carData = json_decode($responseBodyJson, true);

        $carId = intval($carData['car_id'])?:0;
        $carHtml = (base64_decode($carData['result'])?:'');

        $vehicleData = [];
        if (!empty($carHtml)) {
            $vehicleData = $this->vehicleHtmlDetailsToArray($carHtml, $carId);
        }

        return $vehicleData;
    }

}
