<?php

class Controller
{
    protected $db;
    protected $data;
    protected $user;
    protected $post_data = [];
    protected $get_data = [];
    protected $request = (object)["post" => [], "get" => []];

    public function __construct($data = [], $conn = null)
    {

        $this->data = $data;
        if ($conn) {
            $this->db = $conn;
        } else {
            require __DIR__ . "/db.php";
            $this->db = new DB();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputJSON = file_get_contents('php://input');
            $this->request->post= json_decode($inputJSON, true);
        }

        if (!empty($_GET)) {
            foreach ($_GET as $key => $item) {
                $this->request->get[$key] = urldecode($item);
            }
        }
    }

    public function loadModel($model)
    {
        $path = __DIR__ . "/models/" . $model;
        if (file_exists($path) && is_file($path)) {
            require_once $path;
            $class_name = "model_" . $model;
            if (class_exists($class_name, false)) {
                $this->{$class_name} = new $class_name($this->db);
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
}