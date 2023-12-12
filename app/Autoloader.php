<?php
class Autoloader
{
    public static function registrate($dir): void
    {
        $autoload = function (string $className) use ($dir) {
            $path = str_replace('\\', '/', $className);
            $path = $dir . "/" . $path . ".php";

            if (file_exists($path)) {
                require_once $path;
            }
        };

        spl_autoload_register($autoload);
    }
}