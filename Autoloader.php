<?php

class Autoloader
{
    static public function loader($className)
    {
        $dist_dirs = ["controller" => "Controller", "model" => "Model"];

        $name_parts = explode("_", $className);
        if (count($name_parts) > 1) {
            $found_dir = array_search($name_parts[0], $dist_dirs);

            $class_path = __DIR__ . DIRECTORY_SEPARATOR . $found_dir . DIRECTORY_SEPARATOR . strtolower(implode('_', array_slice($name_parts, 1))) . ".php";

            if (is_file($class_path)) {
                include_once $class_path;
            }
        } elseif (is_file(__DIR__ . DIRECTORY_SEPARATOR . $className . ".php")) {
            include_once __DIR__ . DIRECTORY_SEPARATOR . $className . ".php";
        }

    }
}

spl_autoload_register('Autoloader::loader');