<?php
require_once(__DIR__ . "/Database.php");
require_once(__DIR__ . "/User.php");
require_once(__DIR__ . "/Logger.php");
require_once(__DIR__ . "/Fpdf.php");

class Recipe 
{
    private $title;
    private $category;
    private $preparationTime;
    private $description;
    private $servings;

    private $quantity = array();
    private $measurement = array();
    private $ingredient = array();
    private $comment = array();
    private $instructions = array();
    private $jsonData = array();

    private $ingredientsCount;
    private $instructionsCount;

    private $mysqli;

    public static $categories = array("Beef","Chicken","Pork","Lamb","Seafood","Pasta","Vegetable","Soup","Dessert");

    public function __construct()
    {
        global $db, $logger;

        $this->jsonData = json_decode(file_get_contents('php://input'), true); // Decode JSON to an array   
        $this->mysqli = $db->getMySQLiConnection();
        $this->mysqli->autocommit(false);

        if(!is_dir(RECIPE_IMAGE_DIR))
        {
            mkdir(RECIPE_IMAGE_DIR, 0777, true);
            $logger->logMessage(basename(__FILE__), __LINE__, "constructor", "Recipe image directory created. path=" . RECIPE_IMAGE_DIR);
        }

        if(!is_dir(PDF_DIR))
        {
            mkdir(PDF_DIR, 0777, true);
            $logger->logMessage(basename(__FILE__), __LINE__, "constructor", "PDF directory created. path=" . PDF_DIR);
        }
    }
    
    public function create($everything=true)
    {
        global $logger;
        $result = true;
    
        $query = "CALL add_recipe(?,?,?,?,?,?,?,?,?,?,?,?,?);"; 

        if($stmt = $this->mysqli->prepare($query))
        {
            $concatQuantity = implode('|',$this->quantity);
            $concatMeasurement = implode('|',$this->measurement);
            $concatIngredient = implode('|',$this->ingredient);
            $concatComment = implode('|',$this->comment);
            $concatInstructions = implode('|',$this->instructions);

            $author = User::getUser();
            
            $stmt->bind_param("ssisisssssisi", $this->title,$this->category,$this->preparationTime,
                                               $this->description,$this->servings, $author,$concatQuantity,
                                               $concatMeasurement,$concatIngredient,$concatComment,
                                               $this->ingredientsCount,$concatInstructions,$this->instructionsCount);

            $logger->logMessage(basename(__FILE__), __LINE__, "create", "CALL add_recipe({$this->title}, {$this->category}, {$this->preparationTime},
                                                                                        {$this->description}, {$this->servings}, {$author}, {$concatQuantity},
                                                                                        {$concatMeasurement}, {$concatIngredient}, {$concatComment},
                                                                                        {$this->ingredientsCount}, {$concatInstructions}, {$this->instructionsCount})");

            if($stmt->execute())
            {
                $this->generatePDF();
                $logger->logMessage(basename(__FILE__), __LINE__, "create", "PDF created.");

                if($everything)
                {
                    copy(IMAGE_DIR . "/default.jpg", RECIPE_IMAGE_DIR . "/{$this->title}.jpg");
                    $logger->logMessage(basename(__FILE__), __LINE__, "create", "Recipe image created.");
                }

                echo "Recipe Added!";
            }
            else
            {
                $logger->logMessage(basename(__FILE__), __LINE__, "create", "Error creating recipe. error={$mysqli->error}");
                $result = false;
                echo "Recipe title is already taken.";
            }
        }
        else
        {
            $logger->logMessage(basename(__FILE__), __LINE__, "create", "Error creating recipe. error={$mysqli->error}");
            die("Error preparing add sql statement.");
        }
        
        return $result;
    }   
    
    public function delete($everything=true)
    {
        global $logger;
    
        $result = true;
        $query = "CALL delete_recipe(?,?);";    
        
        if($stmt = $this->mysqli->prepare($query))
        {
            $newTitle = false;
            $author = User::getUser();
    
            if(!$everything) //edit recipe
            {
                if( !isset($_SESSION) )
                {
                    session_start();
                }

                $new_image_path = RECIPE_IMAGE_DIR . "/{$this->jsonData['title']}.jpg";
                $image_path = RECIPE_IMAGE_DIR . "/{$_SESSION['editTitle']}.jpg";

                $newTitle = true;
                
                $stmt->bind_param("ss", $_SESSION['editTitle'], $author);           
            }
            else // delete recipe
            {   
                $image_path = RECIPE_IMAGE_DIR . "/{$this->jsonData['title']}.jpg";
                $pdf_path = PDF_DIR . "/{$this->jsonData['title']}.pdf";
                
                $stmt->bind_param("ss", $this->jsonData['title'], $author);
            }

            $logger->logMessage(basename(__FILE__), __LINE__, "delete", "CALL delete_recipe({$this->jsonData['title']}, {$author}). everything={$everything}");

            if($stmt->execute())
            {           
                if($newTitle)// edit 
                {
                    @rename($image_path, $new_image_path);
                }
                else // delete
                {
                    if(file_exists($image_path))
                    {
                        unlink($image_path);
                    }
                    if(file_exists($pdf_path))
                    {
                        unlink($pdf_path);
                    }
                }
            }
            else
            {
                $logger->logMessage(basename(__FILE__), __LINE__, "delete", "Error deleting recipe. error={$mysqli->error}");
                $result = false;
            }
        }
        else
        {
            $logger->logMessage(basename(__FILE__), __LINE__, "delete", "Error deleting recipe. error={$mysqli->error}");
            die("Error preparing delete sql statement.");
        }
        
        return $result;
    }
    
    public function edit()
    {
        global $logger;

        $result = false;

        $logger->logMessage(basename(__FILE__), __LINE__, "edit", "Editing recipe.");

        if($this->delete(false))
        {
            $logger->logMessage(basename(__FILE__), __LINE__, "edit", "Recipe deleted.");
            
            if($this->validate()) //validate edit fields
            {
                if($this->create(false))
                {
                    $logger->logMessage(basename(__FILE__), __LINE__, "edit", "Recipe created.");
                    $result = true;
                }
                else
                {
                    $logger->logMessage(basename(__FILE__), __LINE__, "edit", "Recipe create failed, will rollback.");
                    $this->mysqli->rollback(); //rollback delete
                }
            }
            else
            {
                $logger->logMessage(basename(__FILE__), __LINE__, "edit", "Recipe validation failed, will rollback.");
                $this->mysqli->rollback(); //rollback delete
            }
        }
        else
        {
            $logger->logMessage(basename(__FILE__), __LINE__, "edit", "Recipe delete failed.");
        }

        return $result;
    }
    
    public static function downloadAsPdf($file)
    {
        $filePath = PDF_DIR . "/{$file}";
        
        if(file_exists($filePath))
        {
            header("Cache-Control: public");
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="'.$file.'"');

            readfile($filePath);
        }
        else
        {
            die("Download Failed. Pdf does not exists.");
        }
    }
    
    public function commit()
    {
        $this->mysqli->commit();
    }
    
    public function closeDatabaseConnection()
    {
        global $db;
        $db->closeConnection();
    }
    
    private function generatePDF()
    {
        $this->ingredientsCount = count($this->ingredient);
        $this->instructionsCount = count($this->instructions);

        $pdf = new FPDF('P', 'in', 'A4');
        
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', '14');
        $pdf->Cell(0,0.8,$this->title,0,1,'C');

        $pdf->SetFont('Arial', '', '9');
        
        $pdf->Cell(0,0.5,"Ingredient:",0,1,'L');    
        for($i=0; $i<$this->ingredientsCount; $i++)
        {
            if( isset($this->comment[$i]) )
            {
                $pdf->Cell(0,0.25,"{$this->quantity[$i]} {$this->measurement[$i]} {$this->ingredient[$i]} {$this->comment[$i]}",0,1,'L');
            }
            else
            {
                $pdf->Cell(0,0.25,"{$this->quantity[$i]} {$this->measurement[$i]} {$this->ingredient[$i]}",0,1,'L');
            }
        }
        
        $pdf->Cell(0,0.2,"",0,1,'L');
        $pdf->Cell(0,0.5,"Instructions:",0,1,'L');

        for($i=0, $j=1; $i<$this->instructionsCount; $i++, $j++)
        {
            $pdf->MultiCell(0,0.2,"{$j}. {$this->instructions[$i]}" ,0,'L');
            $pdf->Cell(0,0.1,"",0,1,'L');
        }

        $pdf->output(PDF_DIR . "/{$this->title}.pdf", "F");
    }
    
    public function validate()
    {       
        if(!empty($this->jsonData['title']) && !empty($this->jsonData['preparationTime']) && !empty($this->jsonData['servings']) && !empty($this->jsonData['description']))
        {
            $this->quantity = array_map("trim", $this->jsonData['quantities']);   
            $this->measurement = array_map("trim", $this->jsonData['measurements']);
            $this->ingredient = array_map("trim", $this->jsonData['ingredients']);
            $this->comment = array_map("trim", $this->jsonData['comments']);
            $this->instructions = array_map("trim", $this->jsonData['instructions']);

            $this->ingredientsCount = count($this->quantity);
            $this->instructionsCount = count($this->instructions);
            
            if(!is_numeric($this->jsonData['preparationTime']))
            {
                echo "Preparation time should be a number.";
                return false;
            }
            else if(!is_numeric($this->jsonData['servings']))
            {
                echo "Servings should be a number.";
                return false;
            }
            
            for($i = 0; $i < $this->ingredientsCount; $i++)
            {
                if(empty($this->measurement[$i]) || empty($this->ingredient[$i]))
                {
                    echo "Please complete all fields.";
                    return false;   
                }
                
                if( !is_numeric($this->quantity[$i]) )
                {
                    echo "quantity should be a number.";
                    return false;
                }
            }
            
            foreach($this->instructions as $instruction)
            {
                if( empty($instruction) )
                {
                    echo "Please complete all fields.";
                    return false;
                }               
            }
            
            $this->title = trim($this->jsonData['title']);
            $this->category = $this->jsonData['category'];
            $this->preparationTime = $this->jsonData['preparationTime'];
            $this->servings = $this->jsonData['servings'];
            
            if( empty($this->jsonData['description']) )
            {
                $this->description = "none";
            }
            else
            {
                $this->description = trim($this->jsonData['description']);
            }
            
            return true;
        }
        else
        {
            echo "Please complete all fields.";
            return false;
        }
    }
}
?>