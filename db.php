<?php

class DB
{
    public static $conn;

    function __construct()
    {
        if (!self::$conn || !self::$conn->ping()) {
            $this->connect();
        }
    }

    private function connect()
    {
        require_once __DIR__ . "/db_credentials.php";

        self::$conn = mysqli_connect($credentials["host"], $credentials["user"], $credentials["password"], $credentials["db"]) or die("could not connect to mysql");
        mysqli_set_charset(self::$conn, "utf8mb4");
    }

    public function query($query)
    {
        $q_data = self::$conn->query($query);
        $first_word = strtolower(explode(' ', $query)[0]);
        if ($first_word == "select" || $first_word == "show") {
            $rows = [];
            if ($q_data && $q_data->num_rows) {

                if ($q_data->num_rows) {
                    while ($result_row = $q_data->fetch_assoc()) {
                        $rows[] = $result_row;
                    }
                }
            }
            $q_data->row = current($rows);
            $q_data->rows = $rows;
        }
        return $q_data;
    }

    public function escape($value)
    {
        if (is_array($value)) {
            $arr = [];
            foreach ($value as $key => $item) {
                $arr[$key] = $this->escape($item);
            }
            return $arr;
        }
        return self::$conn->real_escape_string($value);
    }

    public function insert_id()
    {
        return self::$conn->insert_id;
    }

    public function error()
    {
        return self::$conn->error;
    }

    public static function close()
    {
        return self::$conn->close();
    }

}
