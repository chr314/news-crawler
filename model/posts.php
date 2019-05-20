<?php

class Model_Posts extends Model
{
    function getPosts($search)
    {
        $sql = "";

        if (!empty($search["search"])) {
            $sql .= " AND p.title LIKE '%{$this->db->escape($search["search"])}%'";
        }

        if (!empty($search["slogan"])) {
            $sql .= " AND p.slogan='{$this->db->escape($search["slogan"])}'";
        }

        if (!empty($search["source_id"])) {
            $sql .= " AND p.source_id='" . (int)$search["source_id"] . "'";
        }

        if (!empty($search["order"])) {
            $sql .= " AND p.source_id='" . (int)$search["source_id"] . "'";
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