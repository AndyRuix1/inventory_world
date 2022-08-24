<?php
include_once '../db.php';

class User extends DB
{

    public function __construct()
    {
        parent::__construct();
    }

    public function isValidCredentials($usr, $pss)
    {
        if (!$usr || !$pss) return false;
        $pass = md5($pss);
        $query = $this->connect()->prepare("SELECT * FROM users WHERE username=:user AND pass=:pass");
        $result = $query->execute(['user' => $usr, 'pass' => $pass]);
        return ($query->rowCount() > 0);
    }

    public function usernameExist($username) {
        if ($username === NULL) return false;
        $query = $this->connect()->prepare("SELECT * FROM users WHERE username=:user");
        $query->execute(['user' => $username]);
        return ($query->rowCount() > 0);
    }

    public function getUser($usr, $pss) {
        if (!$usr || !$pss) return false;
        $pass = md5($pss);
        $query = $this->connect()->prepare("SELECT * FROM users WHERE username=:user AND pass=:pass");
        $result = $query->execute(['user' => $usr, 'pass' => $pass]);
        if ($result && $query->rowCount() > 0) return $query->fetch(PDO::FETCH_ASSOC);
        return false;
    }

    public function registerUser($username, $name, $pass) {
        if (!$username || !$name || !$pass) return false;
        if ($this->usernameExist($username)) return false;
        $md5pass = md5($pass);
        $query = $this->connect()->prepare("INSERT INTO users (id, username, fullname, pass) VALUES (NULL, :username, :fullname, :pass)");
        $result = $query->execute(['username' => $username, 'fullname' => $name, 'pass' => $md5pass]);
        return ($result && $query->rowCount() > 0);
    }
}
