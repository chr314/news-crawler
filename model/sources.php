<?php

class Model_Sources extends Model
{
    function getSources($data = [])
    {
        $sql = "";

        if (!empty($data["search"])) {
            $sql .= " AND s.name LIKE '%{$this->db->escape($data["search"])}%'";
        }

        return $this->db->query("SELECT * FROM sources s WHERE 1=1 " . $sql)->rows;
    }

    function getSource($id)
    {
        return $this->db->query("SELECT * FROM sources WHERE source_id=" . (int)$id)->row;
    }
}