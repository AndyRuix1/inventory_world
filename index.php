<?php include_once './template/header.php'; ?>

<div class="p-5">
    <div class="container container-fluid">
        <div class="row">
            <div class="col-4">
                <img src="https://cdn-icons-png.flaticon.com/512/1556/1556230.png" alt="Imagen No Cargada." class="img-fluid rounded-lg">
            </div>
            <div class="col-8">
                <h1 class="display-3">INVENTORY WORLD</h1>
                <p class="lead">¡Bienvenido a inventory World!</p>
                <hr class="my-2">
                <p>Aquí podrás crear inventarios con productos de manera sencilla</p>
                <p class="lead">
                    <?php if ($isLoged) { ?>
                        <a class="btn btn-outline-success btn-lg" href="inventories.php" role="button">¡Ver Inventarios!</a>
                    <?php } else { ?>
                        <a class="btn btn-outline-primary btn-lg" href="login.php" role="button">¡Registrate o inicia sesion!</a>
                    <?php } ?>
                </p>

            </div>
        </div>

    </div>
</div>



<?php include_once './template/footer.php'; ?>