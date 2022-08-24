<?php
include_once 'db.php';
class Inventory extends DB
{
    protected $userSession;

    public function __construct()
    {
        parent::__construct();
        $this->userSession = $_SESSION['user'];
    }
    public function getInventories()
    {
        $query = $this->connect()->prepare('SELECT id, inventory_name, inventory_description FROM inventory WHERE owner_id=:id');
        $result = $query->execute(['id' => $this->userSession['id']]);

        if ($result && $query->rowCount() > 0) return $query->fetchAll(PDO::FETCH_ASSOC);
        return false;
    }

    public function getInventoryInfo($inventoryId) {
        if (!$inventoryId || !is_numeric($inventoryId)) return false;
        $query = $this->connect()->prepare('SELECT * FROM inventory WHERE id=:inventory_id AND owner_id=:owner_id');
        $query->execute(['inventory_id' => $inventoryId, 'owner_id' => $this->userSession['id']]);

        if ($query->rowCount() > 0) return $query->fetch(PDO::FETCH_ASSOC);

        return false;
    }


    public function inventoryExist($inventoryName, $inventoryId = NULL) {
        if (!$inventoryName) return false;
        //Optional ID, Check if exist inventory name omiting this ID.
        if(is_numeric($inventoryId)){
            $query = $this->connect()->prepare('SELECT * FROM inventory WHERE inventory_name=:inventory_name AND owner_id=:owner_id AND id!=:inventory_id');
            $query->execute(['inventory_id' => $inventoryId, 'owner_id' => $this->userSession['id'], 'inventory_name' => $inventoryName]);
            return ($query->rowCount() > 0);
        }

        $query = $this->connect()->prepare('SELECT * FROM inventory WHERE inventory_name=:inventory_name');
        $result = $query->execute(['inventory_name' => $inventoryName]);
        return ($result && $query->rowCount() > 0);
    }

    public function createInventory($inventoryName, $inventoryDescription)
    {
        if (!$inventoryName || !$inventoryDescription || $this->inventoryExist($inventoryName)) return false;
        $query = $this->connect()->prepare('INSERT INTO inventory (id, owner_id, inventory_name, inventory_description) VALUES (NULL, :owner_id, :inventory_name, :inventory_description);');
        $result = $query->execute(['owner_id' => $this->userSession['id'], 'inventory_name' => $inventoryName, 'inventory_description' => $inventoryDescription]);
        return ($result && $query->rowCount() > 0);
    }

    public function updateInventory($inventoryId, $inventoryName, $inventoryDescription) {
        if (!$inventoryId || !$inventoryName || !$inventoryDescription) return false;
        $query = $this->connect()->prepare('UPDATE inventory SET inventory_name=:inventory_name, inventory_description=:inventory_description WHERE owner_id=:owner_id AND id=:inventory_id');
        $query->execute(['inventory_id' => $inventoryId, 'owner_id' => $this->userSession['id'], 'inventory_name' => $inventoryName, 'inventory_description' => $inventoryDescription]);
      
        return ($query->rowCount() > 0);
    }

    public function deleteInventory($inventoryId) {
        if (!$inventoryId) return false;
        $query = $this->connect()->prepare('DELETE FROM products WHERE inventory_id=:inventory_id');
        $query->execute(['inventory_id' => $inventoryId]);
        $query = $this->connect()->prepare('DELETE FROM inventory WHERE id=:inventory_id AND owner_id=:owner_id');
        $query->execute(['inventory_id' => $inventoryId, 'owner_id' => $this->userSession['id'] ]);
        return ($query->rowCount() > 0);
    }
}
