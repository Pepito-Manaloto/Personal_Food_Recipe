<?php
class Database
{
    const CHARSET = "utf8mb4";
    private $host = "localhost";
    private $username = "root";
    private $password = "root";
    private $schema = "personal_food_recipe";
    
    private $mysqli;
    private $pdo;

    public function getMySQLiConnection()
    {
        $this->mysqli = new mysqli($this->host, $this->username, $this->password, $this->schema);
        
        if( mysqli_connect_errno() )
        {
            die("Could not connect");
        }
        else
        {
            $this->mysqli->set_charset(self::CHARSET);
            return $this->mysqli;
        }
    }

    public function getPDOConnection()
    {
        try
        {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->schema};charset=" . self::CHARSET, $this->username, $this->password);
        }
        catch(PDOException $e)
        {
            die("Could not connect. {$e}");
        }
        
        return $this->pdo;
    }

    public function closeConnection()
    {
        if(isset($this->mysqli))
        {
            $this->mysqli->close();
        }

        $this->pdo = null;
    }
}

$db = new Database();

?>