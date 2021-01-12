<?php

namespace App\Utils;

use App\Exception\Exception404;
use App\Exception\ValidationException;

class Router
{
    public function process()
    {
        try {
            $action = $this->getAction();
            $controller = $action[0];
            $method = $action[1];
            $object = new $controller;
            $object->$method();
            unset($_SESSION['errors']);
        } catch (Exception404 $exception) {
            return view('404');
        } catch (ValidationException $exception) {
            $this->handleValidationException($exception);
        } catch (\Exception $exception) {
            //
        }
    }

    /**
     * @return array
     * @throws Exception404
     */
    private function getAction() : array
    {
        // Получаем PATH от ссылки
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // Разбиваем ссылку на массив по элементам
        $url = explode('/', $url);

        // Формируем полный неймспейс класса
        if (empty($url[1])) {
            $controller = '\App\Controller\HomeController';
        } else {
            $controller = '\App\Controller\\' . ucfirst($url[1]) . 'Controller';
            if (!class_exists($controller)) {
                throw new Exception404('Error 404');
            }
        }

        if (empty($url[2])) {
            $method = 'index';
        } else {
            $method = $url[2];
        }

        if (!method_exists($controller, $method)) {
            throw new Exception404('Error 404');
        }
        return [$controller, $method];
    }

    private function handleValidationException(ValidationException $exception)
    {
        $referer = parse_url($_SERVER['HTTP_REFERER']);
        $url = 'http://' . $referer['host'] . $referer['path'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_SESSION['errors'] = $exception->getErrors();
            $_SESSION['data'] = $_POST;
        } else {

        }

        header('Location: ' . $url);
        exit;
    }
}