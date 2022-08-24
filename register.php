<?php
include_once './template/header.php';
if ($_POST['submit_button'] == 'register') {
    $notification->setStyle('danger');
    $notification->setTitle('Ha ocurrido un error');
    $r_username = $_POST['username'];
    $r_name = $_POST['name'];
    $r_password = $_POST['password'];
    
    if (strlen($r_username) < 4 || strlen($r_username) >= 15) $notification->addMessage("El nombre de usuario debe contener mínimo 5 carácteres y máximo 15.");
    if (strlen($r_name) < 4 || strlen($r_name) >= 30) $notification->addMessage("El nombre debe contener mínimo 5 carácteres y máximo 30.");
    if (strlen($r_password) <= 5 || strlen($r_password) >= 40) $notification->addMessage("Tu contraseña debe tener mínimo 6 carácteres y máximo 40.");
    if (strlen($r_username) > 0 && $user->usernameExist($r_username) === true) $notification->addMessage('El nombre de usuario ingresado ya existe');

    if ($notification->getMessagesCount() == 0) {
        $result = $user->registerUser($r_username, $r_name, $r_password);
        if ($result === false) {
            $notification->addMessage('Ha ocurrido un fallo desconocido al intentar crear tu cuenta.');
            header('Location: register.php');
        }
        $notification->setStyle('success');
        $notification->setTitle('Cuenta Creada');
        $notification->addMessage('Tu cuenta se ha creado satisfactoriamente.');
        header("Location: login.php");
    }else header('Location: register.php');

   
}
?>

<br><br>
<div class="col-3 mx-auto">
    <div class="card text-white bg-dark">
        <div class="card-body">
            <h3 class="card-title">REGISTRATE</h3>
            <p class="card-text">Accede a tu cuenta o crea una</p>
            <hr>
            <form action="register.php" method="POST">

                <div class="form-group m-0 mt-3">
                    <label for="usr">Nombre de usuario</label>
                    <input type="text" name="username" id="usr" class="form-control">
                </div>
                <div class="form-group m-0 mt-3">
                    <label for="usr">Tu Nombre</label>
                    <input type="text" name="name" id="usr" class="form-control">
                </div>
                <div class="form-group m-0 mt-3">
                    <label for="psw">Contraseña</label>
                    <input type="password" name="password" id="psw" class="form-control">
                </div>
                <button type="submit" name="submit_button" value="register" class="btn btn-outline-success w-100 mt-4">Registrarse</button>
                <br><br>
                <p>¿Ya tienes una cuenta? <a href="login.php" class="text-decoration-none">Accede ahora.</a></p>

            </form>

        </div>
    </div>
</div>
<br><br>



<?php include_once './template/footer.php'; ?>