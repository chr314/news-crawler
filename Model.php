<?php

class Model
{
    protected $db;

    public function __construct($conn = null)
    {

        if ($conn) {
            $this->db = $conn;
        } else {
            require_once __DIR__ . "/db.php";
            $this->db = new DB();
        }

    }

    public function loadModel($model)
    {
        $class_name = "Model_" . $model;
        if (class_exists($class_name)) {
            if (!isset($this->model)) {
                $this->model = new stdClass();
            }
            $this->model->{$model} = new $class_name($this->db);
            return true;
        }
        return false;
    }

}