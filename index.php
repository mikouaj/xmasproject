<?php
session_start();

include "model/user.php";
include "controller/login.php";
include "controller/xmas.php";
include "controller/admin.php";
include "controller/lottery.php";
include "controller/presents.php";

$pages = array("login"=>"LoginController","xmas"=>"XmasController","admin"=>"AdminController","lottery"=>"LotteryController","presents"=>"PresentsController");
        
$userModel = new UserModel();
if(!$userModel->isLoggedin()) {
    $controller = new LoginController();
    $controller->login(filter_input(INPUT_SERVER,'REQUEST_URI'));
} else {
    foreach($pages as $page => $pagecontroller) {
        $get_page = filter_input(INPUT_GET, $page);
        if(isset($get_page)) {
            $controller = new $pagecontroller();
            $found=true;
            break;
        }
    }
    if(!isset($found)) {
        $controller=new XmasController();
    }
    $controller->process();
}