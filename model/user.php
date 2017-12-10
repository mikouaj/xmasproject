<?php

include_once 'model/model.php';

class UserModel extends Model
{
    public function isLoggedin() {
        if(isset($_SESSION['user_login'])) {
            return true;
        } else {
            return false;
        }
    }

    public function verify($username,$password) {
        try {
            $sth = $this->pdo->prepare('SELECT password from users where username=:user');
            $sth->bindValue(':user', $username, PDO::PARAM_STR);
            $sth->execute();
            $result = $sth->fetch();
        } catch(Exception $e) {
            error_log($e->getMessage()." ".$e->getTraceAsString());
            return false;
        }

        if($result['password']===md5($password)) return true;
        else return false;
    }

    public function setupSession($username) {
        $sth = $this->pdo->prepare('SELECT username,name,surname,level,lottery from users where username=:user');
        $sth->bindValue(':user', $username, PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetch();
        $_SESSION['user_login'] = $username;
        $_SESSION['user_name'] = $result['name'];
        $_SESSION['user_surname'] = $result['surname'];
        $_SESSION['user_level'] = $result['level'];
        $_SESSION['lottery'] = $result['lottery'];
    }

    public function destroySession() {
        session_destroy();
    }

    public function getUserName() {
        if($this->isLoggedin()) {
            return $_SESSION['user_name'];
        } else {
            return false;
        }
    }

    public function hasSantaAccess() {
        if(!$this->isLoggedin()) {
            return false;
        } else {
            if($_SESSION['user_level'] == 0 || $_SESSION['user_level'] == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function get() {
        $sth = $this->pdo->prepare('SELECT username,name,surname,level,lottery from users');
        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
    }

    public function getUser($username) {
        $sth = $this->pdo->prepare('SELECT username,name,surname,level,lottery from users where username=:username');
        $sth->bindValue(':username',$username,PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetch();
        return $result;
    }

    public function getChildren() {
      $sth = $this->pdo->prepare('SELECT username,name from users where level=:level');
      $sth->bindValue(':level',3,PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetchAll();
      return $result;
    }

    public function addUser($level,$login,$password,$name,$surname,$lottery) {
        $sql = "insert into users values(:username,:password,:name,:surname,:level,:lottery)";
        $sth = $this->pdo->prepare($sql);
        $sth->bindValue(':username',$login,PDO::PARAM_STR);
        $sth->bindValue(':password',$password,PDO::PARAM_STR);
        $sth->bindValue(':name',$name,PDO::PARAM_STR);
        $sth->bindValue(':surname',$surname,PDO::PARAM_STR);
        $sth->bindValue(':level',$level,PDO::PARAM_INT);
        $sth->bindValue(':lottery',$lottery,PDO::PARAM_INT);
        $sth->execute();
    }

    public function delUser($username) {
        $sql = "delete from users where username=:username";
        $sth = $this->pdo->prepare($sql);
        $sth->bindValue(':username',$username,PDO::PARAM_STR);
        $sth->execute();
    }

    public function hasLotteryAccess() {
        if(!$this->isLoggedin()) {
            return false;
        } else {
            if($_SESSION['lottery'] == 0) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function getCurrentUsername() {
        if($this->isLoggedin()) {
            return $_SESSION['user_login'];
        } else {
            return null;
        }
    }
}
