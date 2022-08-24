<div class="col-12">
    <div class="col-5 mx-auto mb-3">
        <form action="inventories.php" method="POST">
            <div class="card w-100 bg-dark text-light">
                <div class="card-body">
                    <h4 class="display-4 text-center text-info">Creación de inventario</h4>
                    <p>Estás creando un inventario</p>
                    <div class="form-group">
                        <label for="inventory_name">Nombre del inventario:</label>
                        <input required type="text" minlength="1" maxlength="40"  name="inventory_name" id="inventory_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inventory_description">Descripción del inventario:</label>
                        <textarea required minlength="1" maxlength="60" cols="3" style="resize: none;" name="inventory_description" id="inventory_description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" name="button_submit" value="create_inventory_button" class="btn btn-outline-success w-100">Crear Inventario</button>
                    <small><a href="inventories.php" class="text-decoration-none">Cancelar Creación</a></small>
                </div>
            </div>
        </form>
    </div>
</div>