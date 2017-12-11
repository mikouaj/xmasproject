<?php

include_once 'controller/controller.php';

class PresentsController extends Controller
{
    public function process() {
        $input_a = filter_input(INPUT_GET,'a');
        if (isset($input_a)) {
            switch ($input_a) {
                case 'add':
                    $this->add();
                    break;
                case 'delete':
                    $this->delete();
                    break;
                case 'togglereservation':
                    $this->toggleReservation();
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

    public function show() {
        $view = $this->loadView('presents');
        $username = filter_input(INPUT_GET,'user');
        $onlyTable=false;
        $table = filter_input(INPUT_GET,'table');
        if(isset($table)) { $onlyTable=true; }
        if(isset($username)) {
            $view->showUser($username,$onlyTable);
        } else {
            $view->show($onlyTable);
        }
    }

    public function add() {
         $userModel = $this->loadModel('user');
         $presentsModel = $this->loadModel('presents');
         $name = filter_input(INPUT_POST,'name');
         $description = filter_input(INPUT_POST,'desc');
         $link = filter_input(INPUT_POST,'link');
         if($presentsModel->validateData('presentName',$name) && $presentsModel->validateData('presentDesc',$description) && $presentsModel->validateData('presentLink',$link)) {
             try {
                 $presentsModel->add($userModel->getCurrentUsername(),$name,$description,$link);
             } catch(Exception $ex) {
                $view = $this->loadView('error');
                $view->set('exception', $ex);
                $view->exceptionPage();
             }
         } else {
            $view = $this->loadView('error');
            $view->set('exception', new Exception("Field validation error"));
            error_log("Presents controller : can't validate present fields, name :\"".$name."\", presentDesc : \"".$description."\", presentLink : \"");
            $view->exceptionPage();
         }
    }

    public function delete() {
         $userModel = $this->loadModel('user');
         $presentsModel = $this->loadModel('presents');
         $id = filter_input(INPUT_GET,'id');
         if(is_numeric($id)) {
             try {
                 $result = $presentsModel->getUsername($id);
             } catch (Exception $ex) {
                $view = $this->loadView('error');
                $view->set('exception', $ex);
                $view->exceptionPage();
                return;
             }
             if(!empty($result) && $result['username'] == $userModel->getCurrentUsername()) {
                 $presentsModel->delete($id);
             } else {
                 $view = $this->loadView('error');
                 $view->accessDeniedPage();
             }
         }
    }

    public function toggleReservation() {
      $id = filter_input(INPUT_GET,'id');
      $presentsModel = $this->loadModel('presents');
      $userModel = $this->loadModel('user');

      if(is_numeric($id)) {
        try {
            $present = $presentsModel->getById($id);
            $presentOwner = $userModel->getUser($present['username']);
            $currentUsername = $userModel->getCurrentUsername();
        } catch (Exception $ex) {
           $view = $this->loadView('error');
           $view->set('exception', $ex);
           $view->exceptionPage();
           return;
        }
        if($presentOwner['level']==3 && (empty($present['reservedBy']) || $present['reservedBy']==$currentUsername)) {
          try {
            if(empty($present['reservedBy'])) {
              $presentsModel->setReservation($present['id'],$currentUsername);
            } else {
              $presentsModel->clearReservation($present['id']);
            }
          } catch (Exception $ex) {
             $view = $this->loadView('error');
             $view->set('exception', $ex);
             $view->exceptionPage();
             return;
           }
        } else {
          $view = $this->loadView('error');
          $view->accessDeniedPage();
        }
      }
    }
}
