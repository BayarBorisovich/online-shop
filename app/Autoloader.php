<?php
class Autoloader
{
    public static function registrate(string $dir): void
    {
        $autoload = function (string $className) use ($dir) {
            $path = str_replace('\\', '/', $className);// символ \ namespace, меняем на /
            $path = $dir . "/" . $path . ".php"; // значение текущей родительской директории

            if (file_exists($path)) { // проверяем наличие этого файла
                require_once $path;
            }
        };

        spl_autoload_register($autoload);
    }
}