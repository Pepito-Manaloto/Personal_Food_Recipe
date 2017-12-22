<?php
require_once(__DIR__ . "/Logger.php");

class Database
{
    const CHARSET = "utf8mb4";
    const HOST = "localhost";
    const USERNAME = "root";
    const PASSWORD = "root";
    const SCHEMA = "personal_food_recipe";
    
    private $mysqli;
    private $pdo;

    public function getMySQLiConnection()
    {
        $this->mysqli = new mysqli(self::HOST, self::USERNAME, self::PASSWORD, self::SCHEMA);
        
        if(mysqli_connect_errno())
        {
            http_response_code(500); // Internal Server Error
            throw new Exception("Could not connect.");
        }

        $this->mysqli->set_charset(self::CHARSET);
        return $this->mysqli;
    }

    public function getPDOConnection()
    {
        try
        {
            $this->pdo = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::SCHEMA . ";charset=" . self::CHARSET, self::USERNAME, self::PASSWORD);
        }
        catch(PDOException $e)
        {
            http_response_code(500); // Internal Server Error
            throw new Exception("Could not connect. {$e}");
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

$dbConnection = new Database();

?>