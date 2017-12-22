<?php
require_once(__DIR__ . "/Database.php");
require_once(__DIR__ . "/User.php");
require_once(__DIR__ . "/Logger.php");
require_once(__DIR__ . "/Fpdf.php");

class Recipe
{
    private static $DAY_IN_SECONDS = 86400;

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

    public function __construct()
    {
        global $dbConnection, $logger;

        $this->jsonData = json_decode(file_get_contents('php://input'), true); // Decode JSON to an array
        $this->mysqli = $dbConnection->getMySQLiConnection();
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
            $result = false;
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
                $session = $_SESSION;
                if(!isset($session))
                {
                    session_start();
                }

                $new_image_path = RECIPE_IMAGE_DIR . "/{$this->jsonData['title']}.jpg";
                $image_path = RECIPE_IMAGE_DIR . "/{$session['editTitle']}.jpg";

                $newTitle = true;

                $stmt->bind_param("ss", $session['editTitle'], $author);
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
            $result = false;
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
            $logger->logMessage(basename(__FILE__), __LINE__, "edit", "Recipe delete failed.");
            $this->mysqli->rollback(); //rollback delete (NOTE: currently not rolling back!)
        }
 
        return $result;
    }

    public function getCategories()
    {
        $lastModified = @filemtime('cache.txt');
        // Check if cache does not exists or is already 1 day old, if so then query database to refresh cache.
        if($lastModified == null || $lastModified < time() - self::$DAY_IN_SECONDS)
        {
            $query = "CALL get_categories();";

            if($stmt = $this->mysqli->prepare($query))
            {
                $stmt->execute();
                $stmt->bind_result($id, $name);
                $categories = array();
                $i = 0;
                while($stmt->fetch())
                {
                    $categories[$i]["id"] = $id;
                    $categories[$i]["name"] = $name;
                    $i++;
                }

                // Convert to json string
                $data = json_encode($categories);

                // store query result in cache.txt
                file_put_contents('cache.txt', serialize($data));

                // Convert to array of objects
                return json_decode($data);
            }
            else
            {
                $logger->logMessage(basename(__FILE__), __LINE__, "create", "Error retrieving categories. error={$mysqli->error}");
                throw new Exception("Error preparing select sql statement.");
            }
        }
        else
        {
            $data = json_decode(unserialize(file_get_contents('cache.txt')));
            return $data;
        }
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
            throw new Exception("Download Failed. Pdf does not exists.");
        }
    }

    public function commit()
    {
        $this->mysqli->commit();
    }

    public function closeDatabaseConnection()
    {
        global $dbConnection;
        $dbConnection->closeConnection();
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
        global $logger;

        if(!$this->isRecipeDetailsEmpty())
        {
            if(!$this->isRecipeDetailsValid())
            {
                $logger->logMessage(basename(__FILE__), __LINE__, "validate", "Recipe details not valid.");
                return false;
            }

            $this->setRecipeDetails();
            $this->setIngredientsDetails();
            $this->setInstructionsDetails();

            if(!$this->isIngredientsDetailsValid())
            {
                $logger->logMessage(basename(__FILE__), __LINE__, "validate", "Ingredients details not valid.");
                return false;
            }

            if(!$this->isInstructionsDetailsValid())
            {
                $logger->logMessage(basename(__FILE__), __LINE__, "validate", "Instructions details not valid.");
                return false;
            }

            return true;
        }
        else
        {
            $logger->logMessage(basename(__FILE__), __LINE__, "validate", "Recipe details empty.");
            echo "Please complete all fields.";
            return false;
        }
    }

    private function isRecipeDetailsEmpty()
    {
        return empty($this->jsonData['title']) &&
               empty($this->jsonData['preparationTime']) &&
               empty($this->jsonData['servings']) &&
               empty($this->jsonData['description']);
    }

    private function isRecipeDetailsValid()
    {
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

        return true;
    }

    private function setRecipeDetails()
    {
        $this->title = trim($this->jsonData['title']);
        $this->category = $this->jsonData['category'];
        $this->preparationTime = $this->jsonData['preparationTime'];
        $this->servings = $this->jsonData['servings'];

        if(empty($this->jsonData['description']))
        {
            $this->description = "none";
        }
        else
        {
            $this->description = trim($this->jsonData['description']);
        }
    }

    private function setIngredientsDetails()
    {
        $this->quantity = array_map("trim", $this->jsonData['quantities']);
        $this->measurement = array_map("trim", $this->jsonData['measurements']);
        $this->ingredient = array_map("trim", $this->jsonData['ingredients']);
        $this->comment = array_map("trim", $this->jsonData['comments']);

        $this->ingredientsCount = count($this->quantity);
    }

    private function setInstructionsDetails()
    {
        $this->instructions = array_map("trim", $this->jsonData['instructions']);
        $this->instructionsCount = count($this->instructions);
    }

    private function isIngredientsDetailsValid()
    {
        for($i = 0; $i < $this->ingredientsCount; $i++)
        {
            if(empty($this->measurement[$i]) || empty($this->ingredient[$i]))
            {
                echo "Please complete all fields.";
                return false;
            }

            if(!is_numeric($this->quantity[$i]))
            {
                echo "quantity should be a number.";
                return false;
            }
        }
        
        return true;
    }

    private function isInstructionsDetailsValid()
    {
        foreach($this->instructions as $instruction)
        {
            if(empty($instruction))
            {
                echo "Please complete all fields.";
                return false;
            }
        }
        
        return true;
    }
}
?>