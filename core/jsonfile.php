<?php

/*
 * * @author Saladin
 */

class jsonfile implements file {

    public static function load($path) {
        if (file_exists($path)) {
            $file = fopen($path, "r") or die("Unable to open file!");
            $json = json_decode(fread($file, filesize($path)), true);
            fclose($file);
            return $json;
        }
        return [];
    }

    public static function save($path, $data) {
        $file = fopen($path, "w") or die("Unable to open file!");
        fwrite($file, json_encode($data, true));
        fclose($file);
    }

}
