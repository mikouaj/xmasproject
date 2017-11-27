<?php

include_once 'controller/controller.php';

class AdminController extends Controller
{    
    public function process() {
        $input_a = filter_input(INPUT_GET,'a');
        if (isset($input_a)) {
            switch ($input_a) {
                case 'addUser':
                    $this->adduser();
                    break;
                case 'userTable':
                    $this->showUserTable();
                    break;
                case 'delUser':
                    $this->delUser();
                    break;
                case 'lotteryBox':
                    $this->showLotteryBox();
                    break;
                default:
                    $this->defaultAction();
            }
        } else {
            $this->defaultAction();
        }
    }
    public function defaultAction() {
        $this->show();
    }
    
    public function showUserTable() {
        $view = $this->loadView('admin');
        $view->showUserTable();
    }
    
    public function show() {
        $view = $this->loadView('admin');
        $view->show();
    }
    
    public function adduser() {
        $userModel = $this->loadModel('user');
        if($userModel->hasSantaAccess()) {
            $level = filter_input(INPUT_POST,'level');
            $login = filter_input(INPUT_POST,'login');
            $password = filter_input(INPUT_POST,'password');
            $name= filter_input(INPUT_POST,'name');
            $surname = filter_input(INPUT_POST,'surname');
            $lottery = filter_input(INPUT_POST,'lottery');
            if(is_numeric($level) && is_numeric($lottery) && $userModel->validateData('login',$login) && $userModel->validateData('password',$password) && $userModel->validateData('name',$name) && $userModel->validateData('surname',$surname)) {
                try {
                    $userModel->addUser($level,$login,$password,$name,$surname,$lottery);
                } catch (Exception $e) {
                    $view = $this->loadView('error');
                    $view->set('exception', $e);
                    $view->exceptionPage();
                }   
            } else {
                $view = $this->loadView('error');
                $view->set('exception', new Exception("Field validation error"));
                $view->exceptionPage();
            }
        } else {
            $view = $this->loadView('error');
            $view->accessDeniedPage();
        }
    }
    
    public function delUser() {
        $userModel = $this->loadModel('user');
        if($userModel->hasSantaAccess()) {
            $username = filter_input(INPUT_GET,'user');
            if($userModel->validateData('login',$username)) {
                try {
                    $userModel->delUser($username);
                } catch (Exception $e) {
                    $view = $this->loadView('error');
                    $view->set('exception', $e);
                    $view->exceptionPage();
                }  
            }
        } else {
            $view = $this->loadView('error');
            $view->accessDeniedPage();
        }
    }
    
    public function showLotteryBox() {
        $view = $this->loadView('admin');
        $view->showLotteryBox();
    }
}