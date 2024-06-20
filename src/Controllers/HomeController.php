<?php

namespace VehicleCollection\Controllers;

use VehicleCollection\Models\HomeModel;
use VehicleCollection\View;

class HomeController
{
    private $view;
    private $homeModel;

    public function __construct(View $view, HomeModel $homeModel)
    {
        $this->view = $view;
        $this->homeModel = $homeModel;
    }

    private function summ()
    {
        parse_str(file_get_contents('php://input'), $params);

        $this->view->set('title', 'Summ For Huge Numbers');

//        $this->view->set('params', $params);
        $a = $params['a'] ?? 1;
        $b = $params['b'] ?? 2;

        $this->view->set('a', $a);
        $this->view->set('b', $b);
        $this->view->set('result', $this->homeModel->runSumm($a, $b));

        // muting bottom text
        $this->view->set('ending', ' ');

        // setting main template
        $this->view->set('content', $this->view->renderTemplateByName('blocks/infinitesumm'));

        // page render
        $this->view->render();
    }

    private function fibonacci() {

        parse_str(file_get_contents('php://input'), $params);

        $this->view->set('title','Fibonacci Retriever');

//        $this->view->set('params', $params);
        $position = intval($params['position']??0);
        $this->view->set('position', $position);
        $this->view->set('result', $this->homeModel->fibonacciSeq($position));

        // muting bottom text
        $this->view->set('ending' ,' ');

        // setting main template
        $this->view->set('content', $this->view->renderTemplateByName('blocks/fibonacci'));

        // page render
        $this->view->render();
    }

    private function gearboxBlock(): string
    {
        $this->view->set('gear', $this->homeModel->allGearbox());
        $this->view->set('fuel', $this->homeModel->allFuel());
        return $this->view->renderTemplateByName('blocks/gearbox');
    }

    private function countryBlock(): string
    {
        $this->view->set('data', $this->homeModel->topCountriesStats());
        return $this->view->renderTemplateByName('blocks/countrybox');
    }

    private function milageBlock(): string
    {
        $this->view->set('data', $this->homeModel->milageStats());
        return $this->view->renderTemplateByName('blocks/milagebox');
    }

    private function powerBlock(): string
    {
        $this->view->set('data', $this->homeModel->maxMinPowerStats());
        return $this->view->renderTemplateByName('blocks/powerbox');
    }

    public function index()
    {
        $this->view->set('message', 'Here is collected vehicle stats:');

        $this->view->set('gearbox', $this->gearboxBlock());
        $this->view->set('milagebox', $this->milageBlock());
        $this->view->set('countrybox', $this->countryBlock());
        $this->view->set('powerbox', $this->powerBlock());

        $this->view->render();
    }
}
