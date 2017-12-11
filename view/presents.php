<?php

include_once 'view/view.php';

class PresentsView extends View
{
    public function show($isOnlyTable) {
        $this->set('isEditable',true);
        $this->set('title',"Twoja lista prezentów");
        $this->set('emptyTitle',"Twoja lista prezentów jest pusta, dodaj coś!");

        $usermodel = $this->loadModel('user');
        $presentsmodel = $this->loadModel('presents');
        try {
            $presents = $presentsmodel->get($usermodel->getCurrentUsername());
            $this->set('presents',$presents);
            if($isOnlyTable) {
                $this->render('presentsTable');
            } else {
                $this->render('presents');
            }
        } catch(Exception $e) {
            $this->set('exception', $e);
            $this->render('exception');
            return;
        }
    }

    public function showUser($username,$isOnlyTable=false) {
        $usermodel = $this->loadModel('user');
        $lotterymodel = $this->loadModel('lottery');
        $userData = $usermodel->getUser($username);
        $this->set('currentUsername',$usermodel->getCurrentUsername());
        $selectedUserData = $lotterymodel->getSelectedUsername($this->get('currentUsername'));
        if(!empty($userData) && ($selectedUserData['username'] == $username || $userData['level']==3)) {
            $this->set('isEditable',false);
            if($userData['level']==3) {
              $this->set('isReservationEnabled',true);
            }
            $this->set('title',"Lista prezentów o których marzy ".$userData['name']);
            $this->set('emptyTitle',"Niestety ".$userData['name']." nie dodał(a) jeszcze prezentów");
            try {
                $presentsmodel = $this->loadModel('presents');
                $presents = $presentsmodel->get($userData['username']);
                $this->set('presents',$presents);
                if($isOnlyTable) {
                    $this->render('presentsTable');
                } else {
                    $this->render('presents');
                }
            } catch (Exception $e) {
                $this->set('exception', $e);
                $this->render('exception');
            }
        } else {
            $this->render('accessDenied');
        }
    }
}
