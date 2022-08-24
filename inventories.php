<?php
include_once './template/header.php';
include_once './util/inventoryClass.php';

$inventory = new Inventory();
$inventories = $inventory->getInventories();

$create_inventory = $_GET['create_inventory'] ?? 0;
$edit_inventory = $_GET['edit_inventory'] ?? 0;
$inventoryId = $_GET['ivid'];
$isDeleting = ($_GET['type'] == 'd');

$errorPath = '';
$errors = array();
if ($_POST['button_submit'] == 'create_inventory_button') {
    $inventory_name = $_POST['inventory_name'];
    $inventory_description = $_POST['inventory_description'];
    $errorPath = 'create_inventory=1';

    if (strlen($inventory_name) <= 0 || strlen($inventory_name) > 40) $notification->addMessage('El nombre no puede contener más de 40 carácteres y debe tener mínimo 1.');
    if (strlen($inventory_description) <= 0 || strlen($inventory_description) > 60) $notification->addMessage('La descripción no puede contener más de 60 carácteres y debe tener mínimo 1.');
    if ($inventory->inventoryExist($inventory_name)) $notification->addMessage('Ya tienes un inventario con este nombre');

    if ($inventory->createInventory($inventory_name, $inventory_description) === false) $notification->addMessage('No se ha podido crear el inventario.');

    if ($notification->getMessagesCount() > 0) {
        $notification->setStyle('danger');
        $notification->setTitle('Ha ocurrido un error');
    } else {
        $notification->setStyle('success');
        $notification->setTitle('Realizado');
        $notification->addMessage('Se ha creado el inventario "' . $inventory_name . '"  satisfactoriamente');
        header('location: inventories.php');
    }
} else if ($_POST['button_submit'] == 'edit_inventory_button') {
    $inventory_name = $_POST['inventory_name'];
    $inventory_description = $_POST['inventory_description'];
    $inventory_id = $_POST['ivid'];

    if (strlen($inventory_name) <= 0 || strlen($inventory_name) > 40) $notification->addMessage('El nombre no puede contener más de 40 carácteres y debe tener mínimo 1.');
    if (strlen($inventory_description) <= 0 || strlen($inventory_description) > 60) $notification->addMessage('La descripción no puede contener más de 60 carácteres y debe tener mínimo 1.');
    if ($inventory->inventoryExist($inventory_name, $inventory_id) === true) $notification->addMessage('Ya tienes un inventario con este nombre');

    if ($notification->getMessagesCount() == 0) {
        $update_result = $inventory->updateInventory($inventory_id, $inventory_name, $inventory_description);
        if ($update_result === false) $notification->addMessage("No se pudo editar el inventario, posiblemente no realizaste cambios.");
    }

    if ($notification->getMessagesCount() > 0) {
        $notification->setStyle('danger');
        $notification->setTitle('Ha ocurrido un error');
        header('location: inventories.php?edit_inventory=1&ivid=' . $inventory_id);
    } else {

        $notification->setStyle('success');
        $notification->setTitle('Completado');
        $notification->addMessage('Se ha editado satisfactoriamente el inventario "'.$inventory_name.'"');
        header('location: inventories.php');
    }
}
?>

<div class="container container-fluid">
    <h3 class="display-3 text-center text-black">Bienvenido, <span class="text-warning"><?php echo $userLoged['fullname']; ?></span></h3>
    <div class="row mt-5">
        <?php if ($inventories === false && $create_inventory !== '1') { ?>
            <div class="col-12">
                <div class="p-5">
                    <h1 class="display-3 text-primary">NO TIENES INVENTARIOS</h1>
                    <p class="lead">No tienes inventarios, ¿Por qué no creas uno?</p>
                    <hr class="my-2">
                    <p class="lead">
                        <a class="btn btn-outline-primary btn-lg rounded-pill" href="inventories.php?create_inventory=1" role="button">Crear Inventario</a>
                    </p>
                </div>
            </div>
        <?php } else if ($create_inventory === '1') {
            include_once './inventory_components/create_inventory.php';
        } else if ($edit_inventory === '1') {
            include_once './inventory_components/edit_inventory.php';
        } else if (is_array($inventories)) { ?>
            <div class="col-4">
                <div class="card text-white bg-dark rounded-lg">
                    <div class="card-body">
                        <h3 class="card-title text-center text-primary">Crear Inventario</h3>
                        <p class="card-text text-center">Crea un nuevo inventario ahora.</p>
                        <hr>
                        <a href="<?php echo $URL ?>/inventories.php?create_inventory=1" class="btn btn-outline-info w-100">Crear Inventario</a>
                    </div>
                </div>
            </div>
        <?php foreach ($inventories as $inventory => $row) {
                include './inventory_components/inventories_list.php';
            }
        }
        ?>



    </div>
</div>






<?php include_once './template/footer.php'; ?>