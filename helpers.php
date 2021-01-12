<?php

use App\Utils\View;

function view(string $template, array $data = []): string
{
    $view = new View(__DIR__ . '/view');
    return $view->show($template, $data);
}

function error($name)
{
    if (isset($_SESSION['errors'][$name])) {
        return $_SESSION['errors'][$name];
    }
    return null;
}