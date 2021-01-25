<?php

namespace App\Utils;

use App\Exception\Exception404;
use App\Exception\ValidationException;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Router
{
    const LOG_FILE = __DIR__ . '/../logs/exception.log';

    public function writeLog($errorMessage, $class = __CLASS__)
    {
        $log = new Logger($class);
        $log->pushHandler(new StreamHandler(self::LOG_FILE, Logger::WARNING));
        $str = '';
        foreach ($errorMessage as $key => $item) {
            $str .= ' ' . $key . ' - ' . implode(' and ', $item) . ' |';
        }
        $log->error($str);
    }

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
            $this->writeLog(['page' => ['404']]);
            return view('404');
        } catch (ValidationException $exception) {
            $this->handleValidationException($exception);
        } catch (\Exception $exception) {
            $this->writeLog($exception);
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
            $this->writeLog($exception->getErrors());
            $_SESSION['data'] = $_POST;
        } else {

        }

        header('Location: ' . $url);
        exit;
    }
}