<?php

/**
 * Description of jsonrule
 *
 * @author Saladin
 */
class jsonrule implements rule {

    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function get_status($key, $value) {
        
    }

    public function is_active($key, $value) {
        
    }

    public function is_exist($key, $value) {
        foreach ($this->data as $dat) {
            if ($dat[$key] == $value) {
                return false;
            }
        }
        return true;
    }

    public function set_status($key, $value, $state = "active") {
        
    }

    public function get_position($key, $value) {
        $index = -1;
        foreach ($this->data as $dat) {
            $index++;
            if ($dat[$key] == $value) {
                break;
            }
        }
        return $index;
    }

}
