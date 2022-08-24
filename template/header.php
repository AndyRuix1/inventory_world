<?php
include_once 'db.php';
include_once './util/user.php';
include_once './util/userSession.php';
include_once './util/notificationsClass.php';
$notification = new Notification();

$isLoged = false;
$user = new User();
$userSession = new UserSession();
$URL = 'http://' . $_SERVER['HTTP_HOST'] . "/website";

if ($userSession->getCurrentUser() !== false) {
    $_SESSION['user'] = $userSession->getCurrentUser();
} else if (isset($_SESSION['user'])) {
    $userSession->setCurrentUser($_SESSION['user']);
    $isLoged = true;
};

$userLoged = $userSession->getCurrentUser();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./styles/index.css">
    <title>Inventory World</title>

</head>

<body>

    <nav class="navbar navbar-expand navbar-dark bg-dark text-light">
        <div class="container container-fluid">
            <div class="nav navbar-nav me-auto">
                <a href="index.php" class="navbar-brand">INVENTARY WORLD</a>
                <a class="nav-item nav-link" href="index.php">INICIO</a>
                <?php if ($isLoged) { ?>
                    <a class="nav-item nav-link" href="inventories.php">MIS INVENTARIOS</a>
                    <a class="nav-item nav-link" href="logout.php">CERRAR SESION</a>
                <?php } else { ?>
                    <a class="nav-item nav-link" href="login.php">INICIAR SESION</a>
                <?php } ?>
            </div>
            <?php if ($isLoged == true) { ?>
                <span class="lead"><?php echo $userLoged['username'] ?></span>
            <?php } ?>

        </div>
    </nav>

    <?php if ($notification->getMessagesCount() > 0) { ?>
        <div class="alert alert-<?php echo $notification->getNotifications()['notification_style']; ?> alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <h6 class="display-6 text-<?php echo $notification->getNotifications()['notification_style']; ?>"><?php echo $notification->getNotifications()['notification_title']; ?></h6>
            <ul>
                <?php foreach ($notification->getNotifications()['notification_list'] as $message) { ?>
                    <li><?php echo $message; ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php
    $notification->resetNotifications();
    }
    ?>