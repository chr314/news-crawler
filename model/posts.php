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

        $this->db->query("SELECT * FROM posts p LEFT JOIN sources s ON s.source_id=p.source_id WHERE 1=1 " . $sql)->rows;
    }

    function getPost($id)
    {
        $this->db->query("SELECT * FROM posts p LEFT JOIN sources s ON s.source_id=p.source_id WHERE p.post_id=" . (int)$id)->row;
    }
}