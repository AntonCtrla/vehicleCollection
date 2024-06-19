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
        $this->view->set('message', 'You are on the Home Page!');

        $this->view->set('gearbox', $this->gearboxBlock());
        $this->view->set('milagebox', $this->milageBlock());
        $this->view->set('countrybox', $this->countryBlock());
        $this->view->set('powerbox', $this->powerBlock());

        $this->view->render();
    }
}
