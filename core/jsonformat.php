<?php

/**
 *
 * @author Saladin
 */
class jsonformat implements store_format {

    private $data;

    public function __construct() {
        $this->data = array();
    }

    public function is_match($data, $format) {
        if ($data == null) {
            return [0 => "data_null"];
        }
        $arr_error = array();
        for ($i = 0; $i < count($format); $i++) {
            if (!isset($data[$format[$i]])) {
                array_push($arr_error, $format[$i] . "_not_found");
            }
        }
        if (count($arr_error)) {
            return $arr_error;
        }
        return [0 => "match"];
    }

    public function prepare($data, $format) {
        return $this->is_match($data, $format);
    }

}
