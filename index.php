<?php

require_once __DIR__ . "/Autoloader.php";

if (!empty($_GET["route"]) && preg_match_all("/([\w-]+)\/?/", $_GET["route"], $route_pieces)) {

    if (isset($route_pieces[1]) && is_array($route_pieces[1]) && count($route_pieces[1]) > 1) {
        $route_pieces = $route_pieces[1];
        $class_pieces = array_slice($route_pieces, -2);

        $file_name = $class_pieces[0];
        $class_name = "Controller_" . $file_name;
        $func_name = $class_pieces[1];

        if (!empty($file_name) && !empty($func_name) && file_exists(__DIR__ . "/controller/" . implode('/', array_slice($route_pieces, 0, -1)) . ".php")) {

            if (class_exists($class_name)) {
                $route_class = new $class_name();
                if (is_callable(array($route_class, $func_name))) {
                    $route_class->$func_name();
                    exit;
                }
            }
        }
    }

}

header("Location: /index.php?route=posts/posts");