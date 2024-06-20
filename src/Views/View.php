<?php

namespace VehicleCollection\Views;

class View
{
    protected $data = [];
    protected $template;
    protected $header = 'header';
    protected $menu = 'menu';
    protected $footer = 'footer';


    public function __construct(string $template)
    {
        $this->template = $template;

    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function renderTemplateByName(string $template)
    {
        extract($this->data);
        ob_start();
        if (file_exists(__DIR__ . '/templates/' . $template . '.php')) {
            include __DIR__ . '/templates/' . $template . '.php';
        } else {
            echo '<b class="text-danger">Template <i>'.$template.'</i> not exists </b>';
        }
        $content = ob_get_clean();
        return $content;
    }

    public function render()
    {
        extract($this->data);

        ob_start();
        include __DIR__ . '/templates/' . $this->header . '.php';
        include __DIR__ . '/templates/' . $this->menu . '.php';
        include __DIR__ . '/templates/' . $this->template . '.php';
        include __DIR__ . '/templates/' . $this->footer . '.php';
        $content = ob_get_clean();

        echo $content;
    }

}
