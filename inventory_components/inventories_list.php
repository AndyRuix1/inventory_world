<?php #Component used in: inventories.php; ?>
<div class="col-4">
    <div class="card text-white bg-dark rounded-lg">
        <div class="card-header text-end">
                <a href="inventories.php?edit_inventory=1&ivid=<?php echo $row['id']?>" class="text-decoration-none text-primary cursor-pointer"><i class="fa-solid fa-pen"></i></a>
                <a href="inventories.php?edit_inventory=1&type=d&ivid=<?php echo $row['id']?>" class="text-decoration-none text-danger cursor-pointer"><i class="fa-solid fa-trash-can"></i></a>
        </div>
        <div class="card-body">
            <h3 class="card-title text-center"><?php echo $row['inventory_name']; ?></h3>
            <p class="card-text text-center"><?php echo $row['inventory_description']; ?></p>
            <hr>
            <a href="<?php echo 'inventory.php?ivid=' . $row['id'] ?>" class="btn btn-outline-success w-100">Entrar</a>
        </div>
    </div>
</div>