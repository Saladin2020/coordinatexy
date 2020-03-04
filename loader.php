<?php
//header('Access-Control-Allow-Origin: *');
//header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
date_default_timezone_set("Asia/Bangkok");
require_once './core/constant.php';
require_once './core/blueprint.php';
require_once './core/builder.php';
require_once './core/jsonfile.php';
require_once './core/jsonformat.php';
require_once './core/jsonrule.php';
require_once './workspace/routepage.php';
/*function __autoload($class_name) {
$directorys = array(
'core/',
'workspace/',
);
foreach ($directorys as $directory) {
if (file_exists($directory . $class_name . '.php')) {
require_once($directory . $class_name . '.php');
return;
}
}
}*/

switch ((isset($_GET["page"]) != '') ? $_GET["page"] : '') {
    case 'login':
        routepage::login();
        break;
    case 'logout':
        routepage::logout();
        break;
    case 'add_user':
        routepage::add_user();
        break;
    case 'edit_user':
        routepage::edit_user();
        break;
    case 'get_users':
        routepage::get_users();
        break;
    case 'remove_user':
        routepage::remove_user();
        break;
    case 'activate_user':
        routepage::activate_user();
        break;
    case 'get_house':
        routepage::get_house();
        break;
    case 'register_house':
        routepage::register_house();
        break;
    case 'edit_house':
        routepage::edit_house();
        break;
    case 'remove_house':
        routepage::remove_house();
        break;
    default:
        echo "no page";
        break;
}
