<?php

/*
 * * @author Saladin
 */

interface crud {

    public function create($data);

    public function add($data);

    public function read();

    public function get($position);

    public function update($position, $key, $value);

    public function delete($position);
}

interface file {

    public static function load($path);

    public static function save($data, $path);
}

interface store_format {

    public function is_match($data, $format);

    public function prepare($data, $format);
}

interface rule {

    public function is_exist($key, $value);

    public function is_active($key, $value);

    public function set_status($key, $value, $state = "active");

    public function get_status($key, $value);

    public function get_position($key, $value);
}

interface jstore {

    public function add_data();

    public function remove_data();

    public function edit_data();

    public function show_data();
}
