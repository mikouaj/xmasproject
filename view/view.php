<?php

abstract class View {
    public function loadModel($name, $path='model/') {
        $path=$path.$name.'.php';
        $name=$name.'Model';
        try {
            if(is_file($path)) {
                require_once $path;
                $ob=new $name();
            } else {
                throw new Exception('Can not open model '.$name.' in: '.$path);
            }
        }
        catch(Exception $e) {
            echo $e->getMessage().'<br />
                File: '.$e->getFile().'<br />
                Code line: '.$e->getLine().'<br />
                Trace: '.$e->getTraceAsString();
            exit;
        }
        return $ob;
    }

    public function render($name, $path = 'pages/') {
        $path = $path . $name . '.html.php';
        try {
            if (is_file($path)) {
                require $path;
            } else {
                throw new Exception('Can not open page ' . $name . ' in: ' . $path);
            }
        } catch (Exception $e) {
            echo $e->getMessage() . '<br />
                File: ' . $e->getFile() . '<br />
                Code line: ' . $e->getLine() . '<br />
                Trace: ' . $e->getTraceAsString();
            exit;
        }
    }

    public function set($name, $value) {
        $this->$name = $value;
    }

    public function get($name) {
        return $this->$name;
    }
    
    public function isdefined($name) {
        if(isset($this->$name)) {
            return true;
        } else {
            return false;
        }
    }
}