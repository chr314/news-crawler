<?php

class Model_Crawler_Log extends Model
{

    function addLog($source_id, $url, $count)
    {
        return $this->db->query("INSERT INTO crawler_log SET source_id='{$this->db->escape($source_id)}', request_url='{$this->db->escape($url)}', records_count=" . (int)$count)->row;
    }
}