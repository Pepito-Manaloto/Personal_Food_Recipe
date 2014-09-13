<?php 
require_once(__DIR__ . "/Database.php");
require_once(__DIR__ . "/Recipe.php");

class User
{
    private $username = "";
    private $password = "";
    private $confirmPassword = "";
    private $message = "";
    
    public function __construct()
    {       
        if( isset($_POST['name']) && isset($_POST['password']) )
        {
            $this->name = htmlentities( $_POST['name'] ); //removes html entities
            $this->password = htmlentities( $_POST['password'] );
            if( isset($_POST['confirmPassword']) )
            {
                $this->confirmPassword = htmlentities( $_POST['confirmPassword'] );
            }
        }   
    }

    public static function loggedIn()
    {
        if( !isset($_SESSION) )
        {
            session_start();
        }
        
        return ( isset( $_SESSION['username'] ) && !empty($_SESSION['username']) );
    }

    public static function getUser()
    {
        if(self::loggedIn())
        {
            return $_SESSION['username'];
        }
        else
        {
            header("Location: http://localhost/Recipe/Login/");
            exit;
        }
    }

    private static function setUser($username)
    {
        if( !isset($_SESSION) )
        {
            session_start();
        }
        
        $_SESSION['username'] = $username;
    }
    
    public static function logout()
    {
        if( !isset($_SESSION) )
        {
            session_start();
        }
        
        $_SESSION = array();

        session_destroy();

        header("Location: http://localhost/Recipe/Login/");
    }

    public function getRecipeCount()
    {
        global $db;
        $result = 0;
        
        $mysqli = $db->getMySQLiConnection(); 
        
        $query = "CALL get_recipe_count(?,?)";
        $author = self::getUser();
        $cat = "All";
        
        if( $stmt = $mysqli->prepare($query) )
        {
            $stmt->bind_param("ss", $author, $cat);
            $stmt->execute();
            
            $stmt->bind_result($result);
            
            $stmt->fetch();
        }

        $db->closeConnection(); 
        
        return $result;
    }
    
    public function getRecipeCountByCategory($category)
    {
        global $db;
        $result = 0;
        
        $mysqli = $db->getMySQLiConnection(); 
        
        $query = "CALL get_recipe_count(?, ?)";
        $author = self::getUser();
        
        if( $stmt = $mysqli->prepare($query) )
        {
            $stmt->bind_param("ss", $author, $category);
            $stmt->execute();
            
            $stmt->bind_result($result);
            
            $stmt->fetch();
        }
        
        $db->closeConnection(); 
        
        return $result;
    }
    
    public function showRecipeCountByCategory()
    {
        $result = "";
        
        foreach( Recipe::$categories as $c)
        {
            $result .= "<li> {$c}: ";
            $result .= $this->getRecipeCountByCategory($c);
            $result .= " </li>";
        }
        
        return $result;
    }
    
    public function login()
    {
        global $db;
        
        $mysqli = $db->getMySQLiConnection(); 
        
        if( !empty($this->name) && !empty($this->password) )
        {       
            $query = "CALL user_login(?,?);";

            if( $stmt = $mysqli->prepare($query) )
            {
                $stmt->bind_param("ss",$this->name, $this->password); 
                $stmt->execute();

                $stmt->bind_result($count);
                
                $stmt->fetch();

                if($count < 1)
                {
                    echo "Incorrect username or password.";
                }
                else 
                {
                    if( !isset($_SESSION) )
                        session_start();    
                        
                    self::setUser($this->name); // store session

                    echo "Login Successful!";       
                }
            }   
        }
        else
        {
            echo 'Complete all fields.';
        }
        
        $db->closeConnection(); 
    }
    
    public function update()
    {
        global $db;
        
        $mysqli = $db->getMySQLiConnection();
        
        if( !empty($this->name) )
        {       
            if( $this->correctSyntax() || ( empty($this->password) && empty($this->confirmPassword) && strlen($this->name) > 4 ) )
            {           
                $query = "CALL edit_user(?,?,?);";
                $oldName = self::getUser();
                
                if( $stmt = $mysqli->prepare($query) )
                {
                    $stmt->bind_param("sss", $oldName, $this->name, $this->password);
                    
                    if( $stmt->execute() )
                    {
                        self::setUser($this->name);
                        $this->message = "Success"; 
                    }       
                    else
                    {
                        $this->message = "Username already exists.";
                    }
                }   
            }
        }
        else
        {   
            $this->message = 'Complete all fields.';
        }
        
        echo $this->message;
        
        $db->closeConnection();
    }
    
    public function register()
    {   
        global $db;
        
        $mysqli = $db->getMySQLiConnection();
        
        if( !empty($this->name) && !empty($this->password) && !empty($this->confirmPassword) )
        {       
            if( $this->correctSyntax() )
            {           
                $query = "CALL add_user(?,?);";
                
                if( $stmt = $mysqli->prepare($query) )
                {
                    $stmt->bind_param("ss", $this->name, $this->password);
                    
                    if( $stmt->execute() )
                    {
                        $this->message = "Success"; 
                    }
                    else
                    {   
                        $this->message = "Username already exists.";
                    }
                }   
            }
        }
        else
        {
            $this->message = 'Complete all fields.';
        }
        
        echo $this->message;
        
        $db->closeConnection();
    }
    
    public static function downloadBackup($file)
    {
        $filePath = "\"{$_SERVER['DOCUMENT_ROOT']}/Recipe/backup/{$file}\""; // Add double quotes because file path may have spaces
        exec("mysqldump --routines -uroot -proot --add-drop-database -B personal_food_recipe -r {$filePath}", $output, $return);

        $filePath = str_replace("\"", "", $filePath); // Removes double quotes

        if(file_exists($filePath))
        {
            header("Cache-Control: public");
            header('Content-Description: File Transfer');
            header('Content-Type: application/sql');
            header('Content-Disposition: attachment; filename="' . $file . '"');
            
            readfile($filePath);    
        }
        else
        {
            die("Failed to create backup.");
        }
    }
    
    /********************************/
    private function correctSyntax()
    {
        $result = false;
        if( $this->password != $this->confirmPassword)
        {
            $this->message = "Password and confirm password do not match.";
        }
        else
        {
            if( strlen($this->name) > 4 )
            {
                if( strlen($this->password) > 4 )
                {
                    if( preg_match( '/^[a-zA-Z0-9]*[a-zA-Z]+[0-9]+[a-zA-Z0-9]*$/',$this->password) || preg_match( '/^[a-zA-Z0-9]*[0-9]+[a-zA-Z]+[a-zA-Z0-9]*$/',$this->confirmPassword) )
                    {
                        return true;
                    }
                    else
                    {
                        $this->message = "Password must contain letters and digits.";
                    }
                }
                else
                {
                    $this->message = "Password must be at least 5 characters.";
                }
            }
            else
            {
                $this->message = "Username must be at least 5 characters.";
            }
        }

        return $result;
    }
}
?>