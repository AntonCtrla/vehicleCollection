<?php

namespace VehicleCollection\Views;

class View
{
    protected array $data = [];
    protected string $template;
    protected string $header = 'header';
    protected string $menu = 'menu';
    protected string $footer = 'footer';


    public function __construct(string $template)
    {
        $this->template = $template;

    }

    public function set($key, $value): void
    {
        $this->data[$key] = $value;
    }

    public function renderTemplateByName(string $template): false|string
    {
        extract($this->data);
        ob_start();
        if (file_exists(__DIR__ . '/templates/' . $template . '.php')) {
            include __DIR__ . '/templates/' . $template . '.php';
        } else {
            echo '<b class="text-danger">Template <i>'.$template.'</i> not exists </b>';
        }
        return ob_get_clean();
    }

    public function render(): void
    {
        extract($this->data);

        ob_start();
        include __DIR__ . '/templates/' . $this->header . '.php';
        include __DIR__ . '/templates/' . $this->menu . '.php';
        include __DIR__ . '/templates/' . $this->template . '.php';
        include __DIR__ . '/templates/' . $this->footer . '.php';
        echo ob_get_clean();
    }

}
