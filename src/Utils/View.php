<?php

namespace App\Utils;

class View
{
    private string $templateDir;

    /**
     * View constructor.
     * @param $templateDir
     */
    public function __construct(string $templateDir)
    {
        $this->templateDir = $templateDir;
    }

    public function show(string $template, array $data = []) : string
    {
        // превращаем из массива в набор переменных
        extract($data, EXTR_OVERWRITE);
        // меняем все точки на слеши
        $templatePath = str_replace('.', '/', $template);
        // формируем полный путь к файлу включая назавние файла
        return require $this->templateDir . '/' . $templatePath . '.template.php';
    }
}