<?php

if (!empty($_GET["route"]) && preg_match("/(([a-zA-Z0-9_]*)\/([a-zA-Z0-9_]*))/", $_GET["route"], $route)) {

    $file_name = $route[2];
    $class_name = "Controller_" . $file_name;
    $fun_name = $route[3];

    if (!empty($file_name) && !empty($fun_name) && file_exists(__DIR__ . "/controller/" . $file_name . ".php")) {

        require_once __DIR__ . "/Controller.php";
        require_once __DIR__ . "/Model.php";
        include(__DIR__ . "/controller/" . $file_name . ".php");

        if (class_exists($class_name, false)) {
            $route_class = new $class_name();
            if(is_callable(array($route_class, $fun_name))) {
                $route_class->$fun_name();
                exit;
            }
        }
    }

}

header("Location: /index.php?route=posts/posts");