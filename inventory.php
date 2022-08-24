<?php
include_once './template/header.php';
include_once './util/inventoryClass.php';
include_once './util/productsClass.php';


$view_inventory = $_GET['ivid'] ?? false;
$products = new Products($view_inventory);

$product_name = "";
$product_description = "";
$product_price = "";
$product_count = "";
$productAction = "create_product";
$product_id = "x";

function checkInventoryIdExist($notification){
    if (!is_numeric($_POST['tidx'])) {
        $notification->setStyle('danger');
        $notification->setTitle('Error al guardar');
        $notification->addMessage('No se pudo guardar la información.');
        return header('Location: inventories.php');
    }
}

function validateForm($product_name, $product_description, $product_price, $product_count, $notification)
{
    if (strlen($product_name) <= 0 || strlen($product_name) > 40) $notification->addMessage('El nombre del producto debe contener mínimo un carácter y máximo 40.');
    if (strlen($product_description) <= 0 || strlen($product_description) > 200) $notification->addMessage('La descripción debe contener mínimo 1 carácter y máximo 200');
    if (!$product_price || !is_numeric($product_price)) $product_price = 0;
    if (!$product_count || !is_numeric($product_count)) $product_count = 0;
}


if ($_POST['submit_button'] == 'create_product') {
    checkInventoryIdExist($notification);
    $view_inventory = $_POST['tidx'] + 27;
    $products = new Products($view_inventory);
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $product_count = $_POST['product_count'];
    $errors = validateForm($product_name, $product_description, $product_price, $product_count, $notification);

    if ($notification->getMessagesCount() == 0) {
        $resultSave = $products->createProduct($product_name, $product_description, $product_price, $product_count);
        if ($resultSave === false) $notification->addMessage('No se pudo guardar el nuevo producto.');
    }

    if ($notification->getMessagesCount() > 0) {
        $notification->setTitle('Error al guardar');
        $notification->setStyle('danger');
        return header('Location: inventory.php?ivid=' . $view_inventory);
    } else {
        $notification->setStyle('success');
        $notification->setTitle('Guardado');
        $notification->addMessage('El producto se ha creado correctamente');
        return header('Location: inventory.php?ivid=' . $view_inventory);
    }
} else if ($_POST['submit_button'] == 'edit_product') {
    checkInventoryIdExist($notification);
    $view_inventory = $_POST['tidx'] + 27;
    $product_id = $_POST['pid'];
    $products = new Products($view_inventory);
    $product = $products->getProduct($product_id);
    $product_name = $product['product_name'];
    $product_description = $product['product_description'];
    $product_price = $product['product_price'];
    $product_count = $product['product_count'];
    $productAction = "confirm_edit";
} else if ($_POST['submit_button'] == 'confirm_edit') {
    checkInventoryIdExist($notification);
    $view_inventory = $_POST['tidx'] + 27;
    $product_id = $_POST['pid'];
    $products = new Products($view_inventory);

    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $product_count = $_POST['product_count'];

    $errors = validateForm($product_name, $product_description, $product_price, $product_count, $notification);
    $productExist = $products->productExist($product_id);
    if ($productExist == false) $notification->addMessage('El producto a eliminar no existe');
    if ($notification->getMessagesCount() == 0 && $dbProduct['product_name'] == $product_name && $dbProduct['product_description'] == $product_description && $dbProduct['product_price'] == $product_price && $dbProduct['product_count'] == $product_count) $notification->addMessage('Debes realizar cambios en el formulario');

    if ($notification->getMessagesCount() == 0) {
        $resultSave = $products->updateProduct($product_id, $product_name, $product_description, $product_price, $product_count);
        if ($resultSave === false) $notification->addMessage('No se pudo guardar el nuevo producto. Posiblemente no realizaste cambios.');
    }

    if ($notification->getMessagesCount() > 0) {
        $notification->setTitle('Error al guardar');
        $notification->setStyle('danger');
        return header('Location: inventory.php?ivid=' . $view_inventory);
    } else {
        $notification->setTitle('Guardado');
        $notification->setStyle('success');
        $notification->addMessage('Se han guardado los cambios correctamente');
        return header('Location: inventory.php?ivid=' . $view_inventory);
    }
} else if ($_POST['submit_button'] == 'delete_product') {
    checkInventoryIdExist($notification);
    $view_inventory = $_POST['tidx'] + 27;
    $product_id = $_POST['pid'];
    $products = new Products($view_inventory);
    $productExist = $products->productExist($product_id);
    if ($productExist == false) {
        $notification->setStyle('danger');
        $notification->setTitle('Producto Inexistente');
        $notification->addMessage('El producto a eliminar no existe.');
        header('Location: inventory.php?ivid=' . $view_inventory);
    }
    $products->deleteProduct($product_id);
    $notification->setStyle('success');
    $notification->setTitle('Producto Eliminado');
    $notification->addMessage('El producto se ha eliminado satisfactoriamente');
    $product_id = "x";
    header('Location: inventory.php?ivid=' . $view_inventory);
} else if ($_POST['submit_button'] == 'reset_form') {
    checkInventoryIdExist($notification);
    $view_inventory = $_POST['tidx'] + 27;
    $product_id = "x";
    header('Location: inventory.php?ivid=' . $view_inventory);
}

$inventory = new Inventory();
$inventoryInfo = $inventory->getInventoryInfo($view_inventory);
$productsList = $products->getProducts($view_inventory);

if ($inventoryInfo === false) {
    $notification->setTitle('Inventario Invalido');
    $notification->setStyle('danger');
    $notification->addMessage('El inventario a visualizar no existe.');
    header('Location: inventories.php');
}
?>
<div class="container container-fluid pt-3">
    <div class="card bg-dark text-white">
        <div class="card-header">
            <div class="row">
                <div class="col-4">
                    <a href="inventories.php" class="text-decoration-none text-left btn btn-outline-primary p-2 btn-sm"><i class="fa-solid fa-circle-left fa-2xl"></i></a>
                </div>
                <div class="col-4">
                    <h2 class="text-center"><?php echo $inventoryInfo['inventory_name']; ?></h2>
                </div>
                <div class="col-4 text-end"><small><?php echo count($productsList) . " Productos encontrados"; ?></small></div>
            </div>

            <div>

            </div>

        </div>

        <div class="card-body text-center"><?php echo $inventoryInfo['inventory_description']; ?></div>
    </div>

    <div class="row mt-2">
        <div class="col-md-4">
            <form action="inventory.php" method="POST">
                <div class="card bg-dark text-light">
                    <div class="card-body">
                        <h5 class="text-center">Crear Producto</h5>
                        <p class="text-center">Crear nuevo producto para el actual inventario</p>
                        <br>
                        <?php if ($_POST['submit_button'] == 'edit_product' || $_POST['submit_button'] == 'confirm_edit') { ?>
                            <div class="alert alert-warning" role="alert">
                                <strong>Estás procesando un producto</strong>
                                <form action="inventory.php" method="POST">
                                    <input type="hidden" name="tidx" value="<?php echo $view_inventory - 27; ?>">
                                    <button type="submit" name="submit_button" value="reset_form" class="btn btn-outline-warning btn-sm w-100">Cancelar</button>
                                </form>
                            </div>
                        <?php } ?>
                        <form action="inventory.php" method="POST">
                            <input type="hidden" name="tidx" value="<?php echo $view_inventory - 27; ?>">
                            <input type="hidden" name="pid" value="<?php echo $product_id; ?>">
                            <div class="form-group">
                                <label for="p_name">Nombre de producto</label>
                                <input type="text" value="<?php echo $product_name; ?>" name="product_name" id="p_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="p_description">Descripcion del producto</label>
                                <textarea name="product_description" id="p_description" cols="3" class="form-control" style="resize: none;"><?php echo $product_description; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="p_price">Precio</label>
                                <input type="number" value="<?php echo $product_price; ?>" name="product_price" id="p_price" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="p_count">Cantidad Disponible</label>
                                <input type="number" value="<?php echo $product_count; ?>" name="product_count" id="p_count" class="form-control">
                            </div>
                            <button type="submit" name="submit_button" value="<?php echo $productAction; ?>" class="btn btn-outline-success w-100 mt-3">Guardar</button>
                        </form>


                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-7">
            <?php if ($productsList === false || count($productsList) <= 0) { ?>
                <h4 class="text-danger text-center">Sin Productos</h4>
                <p class="text-center text-light">No tienes productos, ¿Qué tal si agregas uno?</p>
            <?php } else { ?>

                <table class="table table-hover table-striped text-white bg-dark ">
                    <thead>
                        <tr>
                            <th>Cantidad Disponible</th>
                            <th>Producto</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-white">
                        <?php foreach ($productsList as $product => $row) { ?>
                            <tr class="<?php ($product_id == $row['id']) ? print('table-primary') : ''; ?>">
                                <td class="text-white"><?= $row['product_count']; ?></td>
                                <td class="text-white"><?= $row['product_name']; ?></td>
                                <td class="text-white"><?= $row['product_description']; ?></td>
                                <td class="text-white"><?= $row['product_price']; ?></td>
                                <td>
                                    <form action="inventory.php" class="btn-group" method="POST">
                                        <input type="hidden" name="tidx" value="<?php echo $view_inventory - 27 ?>">
                                        <input type="hidden" name="pid" value="<?php echo $row['id']; ?>">

                                        <button name="submit_button" value="edit_product" class="btn btn-outline-primary btn-sm text-center"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button name="submit_button" value="delete_product" class="btn btn-outline-danger btn-sm text-center"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
</div>
<?php include_once './template/footer.php'; ?>