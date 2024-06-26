<?php
class siteOptions
{

    //var $db;
    var $optionsData = array();

    function __construct()
    {

        global $db;

        $optionsData = array();
        $options_res = $db->sql("SELECT * FROM api_data ORDER BY id ASC");
        while ($options_row = $options_res->fetch_assoc()) {

            $optionsData[$options_row['meta_key']] = $options_row['meta_value'];
        }

        $this->optionsData = $optionsData;
    }



    function get($key)
    {

        $data = $this->optionsData;

        if (isset($data[$key])) {
            $result = $data[$key];
        } else {
            $result = "ERROR: OPTIONS KEY PAIR NOT SET";
        }

        return $result;
    }
}
