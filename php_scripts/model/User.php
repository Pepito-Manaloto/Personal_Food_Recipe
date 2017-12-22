<?php
require_once(__DIR__ . "/Database.php");
require_once(__DIR__ . "/Recipe.php");
require_once(__DIR__ . "/Logger.php");

class User
{
    private $username = "";
    private $password = "";
    private $confirmPassword = "";
    private $message = "";
    private $recipe;

    public function __construct()
    {
        $this->username = isset($_POST['username']) ? htmlentities($_POST['username']) : "";
        $this->password = isset($_POST['password']) ? htmlentities($_POST['password']): "";
        $this->confirmPassword = isset($_POST['confirmPassword']) ? htmlentities($_POST['confirmPassword']) : "";

        $this->recipe = new Recipe();
    }

    public static function getSession()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }

        $session = $_SESSION;

        return $session;
    }

    public static function loggedIn()
    {
        $session = self::getSession();

        return (isset($session['username']) && !empty($session['username']));
    }

    public static function getUser()
    {
        if(self::loggedIn())
        {
            $session = $_SESSION;
            return $session['username'];
        }
        else
        {
            header("Location: " . BASE_URL . "/Login/");
            exit;
        }
    }

    private static function setUser($username)
    {
        self::getSession();
        $_SESSION['username'] = $username;
    }

    public static function logout()
    {
        $session = self::getSession();

        $session = array();
        session_destroy();

        header("Location: " . BASE_URL . "/Login/");
    }

    public function getRecipeCount()
    {
        global $dbConnection, $logger;
        $result = 0;

        $mysqli = $dbConnection->getMySQLiConnection();

        $query = "CALL get_recipe_count(?,?)";
        $author = self::getUser();
        $allCategory = "All";

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param("ss", $author, $allCategory);
            $stmt->execute();

            $stmt->bind_result($result);

            $stmt->fetch();
            $logger->logMessage(basename(__FILE__), __LINE__, "getRecipeCount", "CALL get_recipe_count({$author}, {$allCategory})");
        }
        else
        {
            $logger->logMessage(basename(__FILE__), __LINE__, "getRecipeCount", "Error in getting recipe count. error={$mysqli->error}");
        }

        $dbConnection->closeConnection();

        return $result;
    }

    public function getRecipeCountByCategory($category)
    {
        global $dbConnection, $logger;
        $result = 0;

        $mysqli = $dbConnection->getMySQLiConnection();

        $query = "CALL get_recipe_count(?, ?)";
        $author = self::getUser();

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param("ss", $author, $category);
            $stmt->execute();

            $stmt->bind_result($result);

            $stmt->fetch();
            $logger->logMessage(basename(__FILE__), __LINE__, "getRecipeCountByCategory", "CALL get_recipe_count({$author}, {$category})");
        }
        else
        {
            $logger->logMessage(basename(__FILE__), __LINE__, "getRecipeCountByCategory", "Error in getting recipe count by category. error={$mysqli->error}");
        }

        $dbConnection->closeConnection();

        return $result;
    }

    public function showRecipeCountByCategory()
    {
        $result = "";
        $categories = $this->recipe->getCategories();

        foreach($categories as $c)
        {
            $category = $c->name;
            $result .= "<li> {$category}: ";
            $result .= $this->getRecipeCountByCategory($category);
            $result .= " </li>";
        }

        return $result;
    }

    public function login()
    {
        global $dbConnection, $logger;

        $mysqli = $dbConnection->getMySQLiConnection();

        if(!empty($this->username) && !empty($this->password))
        {
            $query = "CALL user_login(?,?);";

            if($stmt = $mysqli->prepare($query))
            {
                $stmt->bind_param("ss", $this->username, $this->password);
                $stmt->execute();

                $stmt->bind_result($count);

                $stmt->fetch();

                if($count < 1)
                {
                    echo "Incorrect username or password.";
                }
                else
                {
                    self::setUser($this->username); // store session

                    echo "Login Successful!";
                }

                $logger->logMessage(basename(__FILE__), __LINE__, "login", "CALL get_recipe_count({$this->username}, *****)");
            }
            else
            {
                $logger->logMessage(basename(__FILE__), __LINE__, "login", "Error in logging in. error={$mysqli->error}");
            }
        }
        else
        {
            echo 'Complete all fields.';
        }

        $dbConnection->closeConnection();
    }

    public function update()
    {
        global $dbConnection, $logger;

        $mysqli = $dbConnection->getMySQLiConnection();

        if(!empty($this->username))
        {
            if($this->correctSyntax() || (empty($this->password) && empty($this->confirmPassword) && strlen($this->username) > 4))
            {
                $query = "CALL edit_user(?,?,?);";
                $oldUsername = self::getUser();

                if($stmt = $mysqli->prepare($query))
                {
                    $stmt->bind_param("sss", $oldUsername, $this->username, $this->password);

                    if($stmt->execute())
                    {
                        self::setUser($this->username);
                        $this->message = "Success";
                    }
                    else
                    {
                        $this->message = "Username already exists.";
                    }

                    $logger->logMessage(basename(__FILE__), __LINE__, "update", "CALL edit_user({$this->oldUsername}, {$this->username}, *****)");
                }
                else
                {
                    $logger->logMessage(basename(__FILE__), __LINE__, "update", "Error in updating user. error={$mysqli->error}");
                }
            }

        }
        else
        {
            $this->message = 'Complete all fields.';
        }

        echo $this->message;

        $dbConnection->closeConnection();
    }

    public function register()
    {
        global $dbConnection, $logger;

        $mysqli = $dbConnection->getMySQLiConnection();

        if(!empty($this->username) && !empty($this->password) && !empty($this->confirmPassword))
        {
            if($this->correctSyntax())
            {
                $query = "CALL add_user(?,?);";

                if($stmt = $mysqli->prepare($query))
                {
                    $stmt->bind_param("ss", $this->username, $this->password);

                    if($stmt->execute())
                    {
                        $this->message = "Success";
                    }
                    else
                    {
                        $this->message = "Username already exists.";
                    }

                    $logger->logMessage(basename(__FILE__), __LINE__, "register", "CALL add_user({$this->username}, *****)");
                }
                else
                {
                    $logger->logMessage(basename(__FILE__), __LINE__, "register", "Error in registering new user. error={$mysqli->error}");
                }
            }
        }
        else
        {
            $this->message = 'Complete all fields.';
        }

        echo $this->message;

        $dbConnection->closeConnection();
    }

    public static function downloadBackup($file)
    {
        global $logger;
        if(!is_dir(BACKUP_DIR))
        {
            mkdir(BACKUP_DIR, 0777, true);
            $logger->logMessage(basename(__FILE__), __LINE__, "downloadBackup", "Backup directory created. path=" . BACKUP_DIR);
        }

        $filePath = "\"" . BACKUP_DIR . "/{$file}\""; // Add double quotes because file path may have spaces
        exec("mysqldump --routines -u" . Database::USERNAME . " -p" . Database::PASSWORD . " --add-drop-database -B " . Database::SCHEMA . " -r {$filePath}", $output, $return);

        $logger->logMessage(basename(__FILE__), __LINE__, "downloadBackup", "Creating backup. output={$output} return={$return}");

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
            throw new Exception("Failed to create backup.");
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
            if(strlen($this->username) > 4)
            {
                if(strlen($this->password) > 4)
                {
                    if(preg_match( '/^[a-zA-Z0-9]*([a-zA-Z]+[0-9]+|[0-9]+[a-zA-Z]+)[a-zA-Z0-9]*$/', $this->password) ||
                       preg_match( '/^[a-zA-Z0-9]*[0-9]+[a-zA-Z]+[a-zA-Z0-9]*$/', $this->confirmPassword))
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