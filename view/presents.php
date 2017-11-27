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
        $selectedUserData = $lotterymodel->getSelectedUsername($usermodel->getCurrentUsername());
        if(!empty($selectedUserData) && $selectedUserData['username'] == $username) {
            $this->set('isEditable',false);
            $this->set('title',"Lista prezentów o których marzy ".$selectedUserData['name']);
            $this->set('emptyTitle',"Niestety ".$selectedUserData['name']." nie dodał(a) jeszcze prezentów");
            try {
                $presentsmodel = $this->loadModel('presents');
                $presents = $presentsmodel->get($selectedUserData['username']);
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