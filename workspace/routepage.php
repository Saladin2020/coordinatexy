<?php

class routepage
{

    public static function login()
    {
        session_start();
        $data = json_decode(file_get_contents("php://input"), true);
        $user = $data["username"];
        $password = md5($data["password"]);
        $rs = jsonfile::load("./store/users.json");
        $jr = new jsonrule($rs);
        if (!$jr->is_exist("username", $user)) {
            $position = $jr->get_position("username", $user);
            $build = new builder();
            $build->create($rs);
            if ($build->get($position)["password_hash"] == $password && $build->get($position)["status"] == "active") {
                $_SESSION = array(
                    'login' => 'pass',
                    'username' => $build->get($position)["username"],
                    'full_name' => $build->get($position)["first_name"] . ' ' . $build->get($position)["last_name"],
                    'department' => $build->get($position)["department"],
                    'group' => $build->get($position)["group"],
                );
                echo json_encode(array(
                    'message' => 'success',
                    'profile' => 'enter',
                ));
            } else {
                echo json_encode(array(
                    'message' => 'fail0',
                    'profile' => 'incorrect',
                ));
            }

        } else {
            echo json_encode(array(
                'message' => 'fail1',
                'profile' => 'incorrect',
            ));
        }
    }

    public static function add_user()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $jf = new jsonformat();
        if ($jf->prepare($data, ADDUSER)[0] == "match") {
            $rs = jsonfile::load("./store/users.json");
            $jr = new jsonrule($rs);
            if ($jr->is_exist("username", $data["username"])) {
                $build = new builder();
                $build->create($rs);
                $data["password_hash"] = md5($data["password_hash"]);
                $data["group"] = "0";
                $data["time_created"] = date("Y-m-d H:i:s");
                $data["status"] = "padding";
                $build->add($data);
                jsonfile::save("./store/users.json", $build->read());
                echo json_encode(array(
                    'message' => 'success',
                    'profile' => $build->read(),
                ));
            } else {
                echo json_encode(array(
                    'message' => 'exist_user',
                    'profile' => $data["username"] . ' already exist',
                ));
            }
        } else {
            echo json_encode(array(
                'message' => 'error',
                'profile' => $jf->prepare($data, ADDUSER)[0],
            ));
        }
    }

    public function edit_user()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $jf = new jsonformat();
        if ($jf->prepare($data, ADDUSER)[0] == "match") {
            $rs = jsonfile::load("./store/users.json");
            $jr = new jsonrule($rs);
            $build = new builder();
            $build->create($rs);
            $jr = new jsonrule($rs);
            $position = $jr->get_position("username", $data["username"]);
            $build->update($position, "first_name", $data["first_name"]);
            $build->update($position, "last_name", $data["last_name"]);
            $build->update($position, "department", $data["department"]);
            $build->update($position, "password_hash", md5($data["password_hash"]));
            $build->update($position, "group", "0");
            $build->update($position, "time_created", date("Y-m-d H:i:s"));
            $build->update($position, "status", "padding");
            jsonfile::save("./store/users.json", $build->read());
            echo json_encode(array(
                'message' => 'update',
                'profile' => $build->read(),
            ));
        } else {
            echo json_encode(array(
                'message' => 'error',
                'profile' => $jf->prepare($data, ADDUSER)[0],
            ));
        }
    }

    public static function get_users()
    {
        //$data = json_decode(file_get_contents("php://input"), true);
        $rs = jsonfile::load("./store/users.json");
        $build = new builder();
        $build->create($rs);
        echo json_encode(array(
            'message' => 'success',
            'profile' => $build->read(),
        ));
    }

    public static function remove_user()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $rs = jsonfile::load("./store/users.json");
        $build = new builder();
        $build->create($rs);
        $jr = new jsonrule($rs);
        $position = $jr->get_position("username", $data["username"]);
        $drs = $build->delete($position);
        if ($drs) {
            jsonfile::save("./store/users.json", $build->read());
            echo json_encode(array(
                'message' => 'removed',
                'profile' => $data["username"],
            ));
        } else {
            echo json_encode(array(
                'message' => 'remove_fail',
                'profile' => 'can\'t remove ' . $data["username"],
            ));
        }
    }

    public function activate_user()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $rs = jsonfile::load("./store/users.json");
        $build = new builder();
        $build->create($rs);
        $jr = new jsonrule($rs);
        $position = $jr->get_position("username", $data["username"]);
        $act = array();
        if ($build->get($position)["status"] == "active") {
            $act = "non_active";
        } else {
            $act = "active";
        }
        $drs = $build->update($position, "status", $act);
        if ($drs) {
            jsonfile::save("./store/users.json", $build->read());
            echo json_encode(array(
                'message' => $act,
                'profile' => $data["username"],
            ));
        } else {
            echo json_encode(array(
                'message' => $act . '_fail',
                'profile' => 'can\'t ' . $act . $data["username"],
            ));
        }
    }

    public static function logout()
    {
        session_start();
        session_destroy();
        header("Location: " . BASE_URL);
    }

    ///////////////////////////////////////////////////////Register House


    public static function get_house()
    {
        //$data = json_decode(file_get_contents("php://input"), true);
        $rs = jsonfile::load("./store/house.json");
        $build = new builder();
        $build->create($rs);
        echo json_encode(array(
            'status' => 'success',
            'message' => $build->read(),
        ));
    }

    public static function register_house()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $jf = new jsonformat();
        if ($jf->prepare($data, REGHOUSE)[0] == "match") {
            $rs = jsonfile::load("./store/house.json");
            $jr = new jsonrule($rs);
            if ($jr->is_exist("hid", $data["hid"])) {
                $build = new builder();
                $build->create($rs);
                $data["time_explore"] = date("Y-m-d H:i:s");
                $build->add($data);
                jsonfile::save("./store/house.json", $build->read());
                echo json_encode(array(
                    'status' => 'success',
                    'message' => $build->read(),
                ));
            } else {
                echo json_encode(array(
                    'status' => 'exist_house',
                    'message' => $data["hid"] . ' already exist',
                ));
            }
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => $jf->prepare($data, REGHOUSE)[0],
            ));
        }
    }

    public function edit_house()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $jf = new jsonformat();
        if ($jf->prepare($data, REGHOUSE)[0] == "match") {
            $rs = jsonfile::load("./store/house.json");
            $jr = new jsonrule($rs);
            $build = new builder();
            $build->create($rs);
            $jr = new jsonrule($rs);
            $position = $jr->get_position("hid", $data["hid"]);
            $build->update($position, "hid", $data["hid"]);
            $build->update($position, "haddress", $data["haddress"]);
            $build->update($position, "hmo", $data["hmo"]);
            $build->update($position, "hdistrict_number", $data["hdistrict_number"]);
            $build->update($position, "hamphur_number", $data["hamphur_number"]);
            $build->update($position, "hprovince_number", $data["hprovince_number"]);
            $build->update($position, "hdistrict_name", $data["hdistrict_name"]);
            $build->update($position, "hamphur_name", $data["hamphur_name"]);
            $build->update($position, "hprovince_name", $data["hprovince_name"]);
            $build->update($position, "x", $data["x"]);
            $build->update($position, "y", $data["y"]);
            $build->update($position, "explorer", $data["explorer"]);
            $build->update($position, "time_explore", date("Y-m-d H:i:s"));
            jsonfile::save("./store/house.json", $build->read());
            echo json_encode(array(
                'status' => 'update',
                'message' => $build->read(),
            ));
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => $jf->prepare($data, REGHOUSE)[0],
            ));
        }
    }

    public static function remove_house()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $rs = jsonfile::load("./store/house.json");
        $build = new builder();
        $build->create($rs);
        $jr = new jsonrule($rs);
        $position = $jr->get_position("hid", $data["hid"]);
        $drs = $build->delete($position);
        if ($drs) {
            jsonfile::save("./store/house.json", $build->read());
            echo json_encode(array(
                'status' => 'removed',
                'message' => $data["hid"],
            ));
        } else {
            echo json_encode(array(
                'status' => 'remove_fail',
                'message' => 'can\'t remove ' . $data["hid"],
            ));
        }
    }
    

}