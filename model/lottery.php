<?php

include_once 'model/model.php';

class LotteryModel extends Model
{
    public function isActive() {
        try {
            $sth = $this->pdo->prepare('SELECT 1 from lottery');
            $sth->execute();
        } catch (Exception $ex) {
            return false;
        }
        return true;
    }
    
    public function start() {
        $str = "CREATE TABLE lottery (
                username VARCHAR(20) NOT NULL,
                name VARCHAR(20),
                PRIMARY KEY(`username`)) DEFAULT CHARACTER SET = utf8";
        $sth = $this->pdo->prepare($str);        
        $sth->execute();
        $sth2 = $this->pdo->prepare("select username from users where lottery=1");
        $sth2->execute();
        $results = $sth2->fetchAll();
        foreach($results as $result) {
            $sth3 = $this->pdo->prepare("insert into lottery(username) values(:username)");
            $sth3->bindValue(':username',$result['username'],PDO::PARAM_STR);
            $sth3->execute();
        }
    }
    
    public function stop() {
        $sth = $this->pdo->prepare("DROP TABLE lottery");        
        $sth->execute();        
    }
    
    public function random($username) {
        $sth = $this->pdo->prepare("SELECT name from lottery where username=:username");   
        $sth->bindValue(':username', $username, PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetch();
        if(empty($result)) {
            throw new Exception("User not in lottery");
        }
        if(!is_null($result['name'])) {
            throw new Exception("Ranom name for user is already present");
        }
        $sth2 = $this->pdo->prepare("SELECT username from lottery where username!=:username");
        $sth2->bindValue(':username', $username, PDO::PARAM_STR);
        $sth2->execute();
        $lotteryUsers = $sth2->fetchAll();
        
        $array = array();
        foreach($lotteryUsers as $lotteryUser) {
            $array[$lotteryUser['username']]=1;
        }
        $sth3 = $this->pdo->prepare("SELECT name from lottery where name is not null");
        $sth3->execute();
        $alreadySelectedUsers = $sth3->fetchAll();
        foreach($alreadySelectedUsers as $alreadySelectedUser) {
            if(isset($array[$alreadySelectedUser['name']])) {
                unset($array[$alreadySelectedUser['name']]);
            }
        }

        if(strcmp($username,'wiesia')==0 && isset($array['ewa'])) {
          unset($array['ewa']);
        }

        $lotteryArray = array_keys($array);
        
        if(count($lotteryArray)==1) {
            $random = $lotteryArray[0];
        } else {
            $rand = mt_rand(0,count($lotteryArray)-1);
            $random = $lotteryArray[$rand];
        }
        
        if(!isset($random)) {
            throw new Exception("Cant randomly select name");
        }
        
        $sth4 = $this->pdo->prepare("update lottery set name=:name where username=:username");   
        $sth4->bindValue(':name', $random, PDO::PARAM_STR);
        $sth4->bindValue(':username', $username, PDO::PARAM_STR);
        $sth4->execute();
    }
    
    public function getSelectedUsername($username) {
        $sth = $this->pdo->prepare("select l.name as username, u.name as name, u.surname as surname from lottery as l, users as u where l.username=:username and u.username=l.name");
        $sth->bindValue(':username', $username, PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetch();
        return $result;
    }
}
