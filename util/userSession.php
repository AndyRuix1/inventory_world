<?php
class UserSession{
    private $currentUser; 

    function __construct(){
        session_start();
    }

    public function setCurrentUser($user){
        $_SESSION['user'] = $user;
        $this->currentUser = $user;
    }

    public function getCurrentUser(){
        return $this->currentUser === NULL ? false : $this->currentUser;
    }

    public function logout(){
        session_unset();
        session_destroy();
    }
}
?>