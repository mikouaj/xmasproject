<?php

include_once 'view/view.php';

class ErrorView extends View
{
    public function exception() {
        $this->render('exception');
    }
    
    public function exceptionPage() {
        $this->render('exception');
    }
    
    public function accessDeniedPage() {
        $this->render('accessDenied');
    }
}