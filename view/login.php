<?php

include_once 'view/view.php';

class LoginView extends View
{
    public function show() {
        $this->render('login');
    }
}