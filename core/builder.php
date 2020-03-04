<?php

/*
 * * @author Saladin
 */

class builder implements crud {

    private $data;

    public function __construct() {
        $this->data = array();
    }

    public function create($data) {
        $this->data = $data;
    }

    public function add($data) {
        array_push($this->data, $data);
    }

    public function delete($position) {
        if ($position >= count($this->data) || $position < 0) {
            return false;
        } elseif ($position == 0) {
            $this->data = array_splice($this->data, $position + 1);
            return true;
        } else {
            $arr_head = array_splice($this->data, 0, $position);
            $arr_tail = array_splice($this->data, $position, count($this->data));
            $this->data = array_merge($arr_head, $arr_tail);
            return true;
            ;
        }
    }

    public function read() {
        return $this->data;
    }

    public function get($position) {
        return $this->data[$position];
    }

    public function update($position, $key, $value) {
        if ($position >= count($this->data) || $position < 0) {
            return false;
        } else {
            $this->data[$position][$key] = $value;
            return true;
        }
    }

}
