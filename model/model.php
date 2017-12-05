<?php

abstract class Model
{
    protected $dataFields = array();
    protected $pdo;

    public function __construct() {
        try {
            require 'config/config.inc.php';
            $this->pdo = new PDO('mysql:host='.$config['db_host'].';dbname='.$config['db_name'], $config['db_user'], $config['db_pass']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(DBException $e) {
            echo 'Cant connect to database: ' . $e->getMessage();
        }
    }

    public function validateData($type, $value) {
        switch ($type) {
            case "login":
                if (preg_match('/^.{2,12}$/', $value) === 1) { return true; }
                break;
            case "password":
                if (preg_match('/^.{1,50}$/', $value) === 1) { return true; }
                break;
            case "name":
                if (preg_match('/^.{1,50}$/', $value) === 1) { return true; }
                break;
            case "surname":
                if (preg_match('/^.{1,50}$/', $value) === 1) { return true; }
                break;
            case "presentName":
                if (preg_match('/^.{1,512}$/', $value) ===1) { return true; }
                break;
            case "presentDesc":
                if (preg_match('/^.{1,512}$/', $value) === 1) { return true; }
                break;
            case "presentLink":
                if (empty($value) || preg_match('/^.{1,1024}$/', $value) === 1) { return true; }
                break;

        }
        return false;
    }
}
