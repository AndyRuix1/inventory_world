<?php
include_once './template/header.php';

if ($isLoged) return header('Location: index.php');

if ($_POST['submit_button'] == 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $notification->setStyle('danger');
    $notification->setTitle('Ha ocurrido un error');

    if (strlen($username) == 0) $notification->addMessage("El nombre de usuario no puede estar vacío.");
    if (strlen($password) == 0) $notification->addMessage("La contraseña no puede estar vacía.");

    if ($notification->getMessagesCount() == 0) {
        if ($user->isValidCredentials($username, $password)) {
            $userLoged = $user->getUser($username, $password);
            $userSession->setCurrentUser($username);
            $_SESSION['user'] = $userLoged;

            $notification->setStyle('success');
            $notification->setTitle('Bienvenido/a');
            $notification->addMessage('Has iniciado sesión satisfactoriamente como ' . $username);

            return header('Location: index.php');
        } else $notification->addMessage("Las credenciales son inválidas");
    }
    header('Location: login.php');
}
?>

<br><br>

<div class="col-3 mx-auto">
    <div class="card text-white bg-dark">
        <div class="card-body">
            <h3 class="card-title">ACCEDER</h5>
                <p class="card-text">Accede a tu cuenta o crea una.</p>
                <hr>
                <form action="login.php" method="POST" autocomplete="off">
                    <div class="form-group m-0 mt-3">
                        <label for="usr">Nombre de usuario</label>
                        <input type="text" name="username" value="<?php echo $username?>" id="usr" class="form-control">
                    </div>
                    <div class="form-group m-0 mt-3">
                        <label for="psw">Contraseña</label>
                        <input type="password" name="password" id="psw" class="form-control">
                    </div>
                    <button type="submit" name="submit_button" value="login" class="btn btn-outline-success w-100 mt-4">Acceder</button>
                    <br><br>
                    <p>¿No tienes una cuenta? <a href="register.php" class="text-decoration-none">crea una ahora</a></p>
                </form>
        </div>
    </div>
</div>
<br><br>


<?php include_once './template/footer.php'; ?>