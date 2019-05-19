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
        $path = __DIR__ . "/models/" . $model;
        if (file_exists($path)) {
            require_once $path;
            $class_name = "Model_" . $model;
            if (class_exists($class_name, false)) {
                $this->{$path} = new $class_name($this->db);
                return true;
            }
        }
        return false;
    }

}