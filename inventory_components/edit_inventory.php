<?php
if($isDeleting === true && $edit_inventory === '1'){
    $notification->setTitle('Eliminado');
    $notification->setStyle('success');
    $notification->addMessage('Se ha eliminado el inventario');
    $result = $inventory->deleteInventory($inventoryId);
    header('Location: inventories.php');
}

$inventoryInfo = $inventory->getInventoryInfo($inventoryId);

?>

<div class="col-12">
    <div class="col-5 mx-auto mb-3">
        <form action="inventories.php" method="POST">
            <input type="hidden" name="ivid" value="<?php echo $inventoryId;?>"/>
            <div class="card w-100 bg-dark text-light rounded-lg">
                <div class="card-body">
                    <h4 class="display-4 text-center text-info">Editar Inventario</h4>
                    <p>Estás editando el inventario "<?php echo $inventoryInfo['inventory_name'];?>"</p>
                    <div class="form-group">
                        <label for="inventory_name">Nombre del inventario:</label>
                        <input required type="text" value="<?php echo $inventoryInfo['inventory_name'];?>" minlength="1" maxlength="40" name="inventory_name" id="inventory_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inventory_description">Descripción del inventario:</label>
                        <textarea required maxlength="60" cols="3" style="resize: none;" minlength="1" name="inventory_description" id="inventory_description" class="form-control"><?php echo $inventoryInfo['inventory_description'];?></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" name="button_submit" value="edit_inventory_button" class="btn btn-outline-success w-100">Confirmar Cambios</button>
                    <small><a href="inventories.php" class="text-decoration-none">Cancelar Edición</a></small>
                </div>
            </div>
        </form>
    </div>
</div>
