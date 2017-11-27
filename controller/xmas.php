<?php

include_once 'controller/controller.php';

class XmasController extends Controller
{    
    public function process() {
        $input_a = filter_input(INPUT_GET,'a');
        if (isset($input_a)) {
            switch ($input_a) {
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
        $view = $this->loadView('xmas');
        $view->show();
    }
}