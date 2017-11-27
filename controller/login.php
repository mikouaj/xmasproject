<?php

include_once 'controller/controller.php';

class LoginController extends Controller
{    
    public function process() {
        $input_a = filter_input(INPUT_GET,'a');
        if (isset($input_a)) {
            switch ($input_a) {
                case 'logout':
                    $this->logout();
                    break;
                default:
                    $this->defaultAction();
            }
        } else {
            $this->defaultAction();
        }
    }
    public function defaultAction() {
        $this->login();
    }
    
    public function login() {
        $post_username = filter_input(INPUT_POST,'username');
        $post_password = filter_input(INPUT_POST,'password');
        $post_requrl = filter_input(INPUT_POST,'requestedUrl');
        // Set default redirect page after login
        if(!isset($post_requrl)) {
            $post_requrl = 'index.php?xmas';
        }
        // Load view
        $view = $this->loadView('login');
        $view->set('requestedUrl',$post_requrl);
        if(isset($post_username) && isset($post_password)) {
            $model = $this->loadModel('user');
            try {
                $isVerified = $model->verify($post_username,$post_password);
            } catch(Exception $e) {
                $view = $this->loadView('error');
                $view->set('exception', $e);
                $view->exceptionPage();
                return;
            }
            if($isVerified) {
                $model->setupSession($post_username);
                $this->redirect($post_requrl);
            } else {
                $view->set('loginFault',true);
                $view->show();
            }
        } else {
            $view->set('loginFault',false);
            $view->show();
        }
    }
    
    public function logout() {
        $model = $this->loadModel('user');
        $model->destroySession();
        $this->redirect('index.php?xmas');
    }
}