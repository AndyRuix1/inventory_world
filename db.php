<?php
class DB {
    private $host;
    private $usname;
    private $pass;
    private $dbname;
    private $pdo;

    public function __construct() {
        $this->host = "localhost";
        $this->usname = "root";
        $this->pass = "";
        $this->dbname = "inventory_world";
    }

    public function connect() {
        if ($this->pdo instanceof PDO) {
            return $this->pdo;
        };

        try {
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";";
            $opt = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false];
            $this->pdo = new PDO($connection, $this->usname, $this->pass, $opt);
            $this->checkAndCreateTables();
            return $this->pdo;
        } catch (PDOException $Exception) {
            die("Database Connection Error: " . $Exception->getMessage());
        }
    }

    private function checkAndCreateTables() {
        if ($this->pdo instanceof PDO) {
            $tables = [
                //Tabla de usuarios (ID, fullname, username, password)
                "users" => "CREATE TABLE `$this->dbname`.`users` (id INT AUTO_INCREMENT PRIMARY KEY, fullname VARCHAR(30) NOT NULL, username VARCHAR(15) NOT NULL, pass VARCHAR(40) NOT NULL);",
                //Tabla de inventario [relacionado con 'users'] (id, product_name, product_description, owner_id)
                "inventory" => "CREATE TABLE `$this->dbname`.`inventory` (id INT AUTO_INCREMENT PRIMARY KEY, owner_id INT NOT NULL, inventory_name VARCHAR(40) NOT NULL, inventory_description VARCHAR(60) NOT NULL, FOREIGN KEY fk_owner_id(owner_id) REFERENCES users(id));",
                "products" => "CREATE TABLE `$this->dbname`.`products` (id INT AUTO_INCREMENT PRIMARY KEY, inventory_id INT NOT NULL, product_name VARCHAR(40) NOT NULL, product_description VARCHAR(200) NOT NULL, product_price INT NOT NULL, product_count INT NOT NULL, FOREIGN KEY fk_inventory_id(inventory_id) REFERENCES inventory(id));"
            ];
            foreach ($tables as $table => $sqlQuery) {
                $tableExist = $this->pdo->query("SELECT TABLE_SCHEMA, TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_TYPE LIKE 'BASE TABLE' AND TABLE_SCHEMA LIKE '$this->dbname' AND TABLE_NAME = '$table'");
                $row = $tableExist->rowCount();
                if ($row == 0) {
                    $sqlPrepare = $this->pdo->prepare($sqlQuery);
                    $sqlPrepare->execute();
                }
            }
        }
    }
}
?>