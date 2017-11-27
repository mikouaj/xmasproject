<?php

include_once 'view/view.php';

class XmasView extends View
{
    public function show() {
        $usermodel = $this->loadModel('user');
        if(!$usermodel->hasLotteryAccess()) {
            $this->set('hasLottery',false);
        } else {
            $this->set('hasLottery',true);
            $lotterymodel = $this->loadModel('lottery');
            try {
                if(!$lotterymodel->isActive()) {
                    $this->set('isLotteryActive',false);
                } else {
                    $this->set('isLotteryActive',true);
                    $this->set('randomUserData',$lotterymodel->getSelectedUsername($usermodel->getCurrentUsername()));
                }
            } catch (Exception $ex) {
                $this->set('exception',$ex);
                $this->render('exception');
            }
        }
       
        $lotterymodel = $this->loadModel('lottery');

        $this->render('xmas');
    }
}