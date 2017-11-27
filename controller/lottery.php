<?php

include_once 'controller/controller.php';

class LotteryController extends Controller
{    
    public function process() {
        $input_a = filter_input(INPUT_GET,'a');
        if (isset($input_a)) {
            switch ($input_a) {
                case 'start':
                    $this->start();
                    break;
                case 'stop':
                    $this->stop();
                    break;
                case 'random':
                    $this->random();
                    break;
                default:
                    $this->defaultAction();
            }
        } else {
            $this->defaultAction();
        }
    }
    public function defaultAction() {
    }
    
    public function start() {
        $userModel = $this->loadModel('user');
        if($userModel->hasSantaAccess()) {
            $lotteryModel = $this->loadModel('lottery');
            try {
                $lotteryModel->start();
            } catch (Exception $ex) {
                $view = $this->loadView('error');
                $view->set('exception',$ex);
            }
        } else {
            $view = $this->loadView('error');
            $view->accessDeniedPage();
        }
    }
    
    public function stop() {
        $userModel = $this->loadModel('user');
        if($userModel->hasSantaAccess()) {
            $lotteryModel = $this->loadModel('lottery');
            try {
                $lotteryModel->stop();
            } catch (Exception $ex) {
                $view = $this->loadView('error');
                $view->set('exception',$ex);
            }
        } else {
            $view = $this->loadView('error');
            $view->accessDeniedPage();
        }
    }
    
    public function random() {
        $lotteryModel = $this->loadModel('lottery');
        if($lotteryModel->isActive()) {
            $userModel = $this->loadModel('user');
            $username = $userModel->getCurrentUsername();
            try {
                $randomUserData = $lotteryModel->getSelectedUsername($_SESSION['user_login']);
            } catch (Exception $ex) {
                $view = $this->loadView('error');
                $view->set('exception', $ex);
                $view->exceptionPage();
                return;
            }
            if(!empty($randomUserData)) {
                $view = $this->loadView('error');
                $view->set('exception', new Exception("User has already randomly selected"));
                $view->exceptionPage();
            } else {
                try {
                    $lotteryModel->random($username);
                } catch(Exception $ex) {
                    $view = $this->loadView('error');
                    $view->set('exception', $ex);
                    $view->exceptionPage();
                }
            }
        } else {
            $view = $this->loadView('error');
            $view->set('exception', new Exception("Lottery is not active"));
            $view->exceptionPage();
        }
    }
}