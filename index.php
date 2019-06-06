<?php

require_once __DIR__ . "/Autoloader.php";

if (!empty($_GET["route"]) && preg_match_all("/([\w-]+)\/?/", $_GET["route"], $route_pieces)) {

    if (isset($route_pieces[1]) && is_array($route_pieces[1]) && count($route_pieces[1]) > 1) {
        $route_pieces = $route_pieces[1];
        $class_pieces = array_slice($route_pieces, 0, -1);

        $class_name = "Controller";
        foreach ($class_pieces as $class_piece) {
            $class_name .= "_" . ucfirst(strtolower($class_piece));
        }

        $func_name = array_slice($route_pieces,-1)[0];

        if (!empty($func_name) && class_exists($class_name)) {
            $route_class = new $class_name();
            if (is_callable(array($route_class, $func_name))) {
                $route_class->$func_name();
                exit;
            }
        }
    }

}

header("Location: /index.php?route=posts/posts");