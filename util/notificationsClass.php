<?php
class Notification {

    public function __construct() {
        $_SESSION['notification']['style'] = 'danger';
        $_SESSION['notification']['title'] = 'Notificacion';
        $_SESSION['notification']['messages'] = array();
        
    }

    public function setTitle($title) {
        $_SESSION['notification']['title'] = $title;
    }

    public function setStyle($style = 'danger') {
        $_SESSION['notification']['style'] = $style;
    }

    public function addMessage($message) {
        $messagesList = $_SESSION['notification']['messages'] ?? array();
        array_push($messagesList, $message);
        $_SESSION['notification']['messages'] = $messagesList;
    }

    public function getMessagesCount() {
        $messages = $_SESSION['notification']['messages'] ?? array();
        return count($messages);
    }


    public function getNotifications() {
        return [
            'notification_title' => $_SESSION['notification']['title'],
            'notification_style' => $_SESSION['notification']['style'],
            'notification_list' => $_SESSION['notification']['messages']
        ];
    }

    public function resetNotifications() {
        $_SESSION['notification']['style'] = 'danger';
        $_SESSION['notification']['title'] = 'Notificacion';
        $_SESSION['notification']['messages'] = array();
    }
}
?>