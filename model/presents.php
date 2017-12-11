<?php

include_once 'model/model.php';

class PresentsModel extends Model
{
    public function get($username) {
        $sth = $this->pdo->prepare('SELECT id,present,description,link,reservedBy,username from presents where username=:username');
        $sth->bindValue(':username', $username, PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
    }

    public function add($username,$name,$description,$link) {
        if(!empty($link)) {
            $sth = $this->pdo->prepare('insert into presents(username,present,description,link) values(:username,:name,:description,:link)');
            $sth->bindValue(':link', $link, PDO::PARAM_STR);
        } else {
            $sth = $this->pdo->prepare('insert into presents(username,present,description) values(:username,:name,:description)');
        }
        $sth->bindValue(':username', $username, PDO::PARAM_STR);
        $sth->bindValue(':name', $name, PDO::PARAM_STR);
        $sth->bindValue(':description', $description, PDO::PARAM_STR);
        $sth->execute();
    }

    public function getUsername($id) {
        $sth = $this->pdo->prepare('SELECT username from presents where id=:id');
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch();
        return $result;
    }

    public function delete($id) {
        $sql = "delete from presents where id=:id";
        $sth = $this->pdo->prepare($sql);
        $sth->bindValue(':id',$id,PDO::PARAM_INT);
        $sth->execute();
    }
}
