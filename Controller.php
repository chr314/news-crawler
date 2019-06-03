<?php

class Controller
{
    protected $db;
    protected $data;
    protected $user;
    protected $request;

    public function __construct($data = [], $conn = null)
    {
        $this->request = (object)["post" => [], "get" => [], "post_body" => []];
        $this->data = $data;
        if ($conn) {
            $this->db = $conn;
        } else {
            require_once __DIR__ . "/db.php";
            $this->db = new DB();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = file_get_contents('php://input');
            $this->request->post_body = json_decode($input, true);
            if (json_last_error() != JSON_ERROR_NONE) {
                $this->request->post_body = $input;
            }

            if (!empty($_POST)) {
                $this->request->post = $_POST;
            }
        }

        if (!empty($_GET)) {
            foreach ($_GET as $key => $item) {
                $this->request->get[$key] = urldecode($item);
            }
        }
    }

    public function getController($controller, $function, $data = [])
    {
        $path = __DIR__ . "/controller/" . $controller . ".php";
        if (file_exists($path) && is_file($path)) {
            require_once $path;
            $class_name = "Controller_" . $controller;
            if (class_exists($class_name)) {
                $route_class = new $class_name();
                if (is_callable(array($route_class, $function))) {
                    return $route_class->$function($data);
                }
            }
        }
        return false;
    }

    public function loadModel($model)
    {
        $path = __DIR__ . "/model/" . $model . ".php";
        if (file_exists($path) && is_file($path)) {
            require_once $path;
            $class_name = "Model_" . $model;
            if (class_exists($class_name)) {
                if (!isset($this->model)) {
                    $this->model = new stdClass();
                }
                $this->model->{$model} = new $class_name($this->db);
                return true;
            }
        }
        return false;
    }

    public function responseJSON($success = true, $arr = null)
    {
        header('Content-Type: application/json');

        $resp = ["status" => !!$success ? "success" : "error"];
        if ($arr !== null) {
            $resp[!!$success ? "data" : "errors"] = $arr;
        }

        echo json_encode($resp);
        exit;
    }

    public function responseView($view, $data)
    {
        echo $this->renderView($view, $data);
        exit;
    }

    public function renderView($__view, $__data)
    {
        $__path = __DIR__ . "/view/" . $__view . ".php";
        if (is_file($__path)) {
            if ($__data && is_array($__data)) {
                extract($__data, EXTR_PREFIX_SAME, "tpl_var");
            }
            ob_start();
            require $__path;
            $__tpl_result = ob_get_contents();
            ob_end_clean();
            return $__tpl_result;
        }
        return "";
    }
}