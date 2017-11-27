<?php

include_once 'view/view.php';

class AdminView extends View
{
    private function setLottery() {
        $lotteryModel = $this->loadModel('lottery');
        $this->set('lotteryActive',$lotteryModel->isActive());
    }

    public function show() {
        $userModel=$this->loadModel('user');
        if($userModel->hasSantaAccess()) {
            try {
                $users = $userModel->get();
                $this->set('users',$users);
                $this->setLottery();
                $this->render('admin');
            } catch(Exception $e) {
                $this->set('exception', $e);
                $this->render('exception');
                return;                
            }
        } else {
            $this->render('accessDenied');
        }
    }
    
    public function showUserTable() {
        $userModel=$this->loadModel('user');
        if($userModel->hasSantaAccess()) {
            try {
                $users = $userModel->get();
                $this->set('users',$users);
                $this->render('userTable');
            } catch(Exception $e) {
                $this->set('exception', $e);
                $this->render('exception');
                return;                
            }
        } else {
            $this->render('accessDenied');
        }
    }
    
    public function showLotteryBox() {
        $userModel=$this->loadModel('user');
        if($userModel->hasSantaAccess()) {
            try {
                $this->setLottery();
                $this->render('lotteryBox');
            } catch(Exception $e) {
                $this->set('exception', $e);
                $this->render('exception');
                return;                
            }
        } else {
            $this->render('accessDenied');
        }
    }
}