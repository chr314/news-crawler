<?php

class Autoloader
{
    static public function loader($className)
    {
        $dist_dirs = ["controller" => "Controller", "model" => "Model"];

        $name_parts = explode("_", $className);
        if (count($name_parts) > 1) {
            $found_dir = array_search($name_parts[0], $dist_dirs);

            $file_path_pieces = array_slice($name_parts, 1);

            for ($x = 0; $x < count($file_path_pieces); $x++) {
                $file_name = implode("_", array_slice($file_path_pieces, $x));
                $path = __DIR__ . "/" . $found_dir . "/" . implode("/", array_map('strtolower', array_slice($file_path_pieces, 0, $x)));

                $file_arr = glob($path . '*.php', GLOB_NOSORT);
                $file_lcase = strtolower($file_name) . ".php";
                foreach ($file_arr as $file) {
                    if (strtolower(basename($file)) == $file_lcase) {
                        include_once $file;
                    }
                }
            }
        } elseif (is_file(__DIR__ . "/" . $className . ".php")) {
            include_once __DIR__ . "/" . $className . ".php";
        }

    }
}

spl_autoload_register('Autoloader::loader');