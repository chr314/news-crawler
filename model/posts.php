<?php

class Model_Posts extends Model
{
    function getPosts($data = [])
    {
        $sql = "";

        if (!empty($data["search"])) {
            $sql .= " AND p.title LIKE '%{$this->db->escape($data["search"])}%'";
        }

        if (!empty($data["slogan"])) {
            $sql .= " AND p.slogan='{$this->db->escape($data["slogan"])}'";
        }

        if (!empty($data["source_id"]) && $data["source_id"] > 0) {
            $sql .= " AND p.source_id='" . (int)$data["source_id"] . "'";
        }

        if (!empty($data["sort"])) {
            $sql .= " ORDER BY {$this->db->escape($data["sort"])}";
        }

        if (!empty($data["order"])) {
            $sql .= strtolower($data["order"]) == "desc" ? " DESC " : " ASC ";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        return $this->db->query("SELECT * FROM posts p LEFT JOIN sources s ON s.source_id=p.source_id WHERE 1=1 " . $sql)->rows;
    }

    function getPost($id)
    {
        return $this->db->query("SELECT * FROM posts p LEFT JOIN sources s ON s.source_id=p.source_id WHERE p.post_id=" . (int)$id)->row;
    }

    function addPosts($data = [])
    {
        if (!empty($data)) {

            $keys_sql = [];

            foreach (array_keys($data[0]) as $key) {
                $keys_sql[] = "`{$this->db->escape($key)}`";
            }

            $values_sql = [];
            foreach ($data as $key => $item) {
                $arr = array_map(function ($string) {
                    return "'" . $this->db->escape($string) . "'";
                }, $item);

                $values_sql[] = "(" . implode(",", $arr) . ")";
            }

            if (!empty($keys_sql) && !empty($values_sql)) {
                $sql_resp[] = $this->db->query("INSERT INTO posts (" . implode(',', $keys_sql) . ") 
                    VALUES " . implode(',', $values_sql));
            }
            return true;
        }
    }
}