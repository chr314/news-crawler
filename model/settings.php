<?php

class Model_Settings extends Model
{
    function getSettings()
    {
        return $this->db->query("SELECT * FROM settings")->rows;
    }

    function getSetting($id)
    {
        return $this->db->query("SELECT * FROM settings WHERE setting_id=" . (int)$id)->row;
    }

    function getSettingByName($name)
    {
        return $this->db->query("SELECT * FROM settings WHERE name='{$this->db->escape($name)}'")->row;
    }

    function deleteSetting($name)
    {
        return $this->db->query("DELETE FROM settings WHERE name='{$this->db->escape($name)}'");
    }

    function setSetting($name, $value, $isJSON = false)
    {
        $this->deleteSetting($name);
        return $this->db->query("INSERT INTO settings SET name='{$this->db->escape($name)}', value='{$this->db->escape($value)}', is_json=" . (int)$isJSON);
    }
}
