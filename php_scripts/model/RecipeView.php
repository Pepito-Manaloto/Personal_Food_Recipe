<?php
require_once(__DIR__ . "/Database.php");
require_once(__DIR__ . "/Logger.php");

abstract class RecipeView
{   
    protected $title;
    protected $category;
    protected $preparationTime;
    protected $description;
    protected $servings;
    
    protected $ingredients = array();
    protected $quantity = array();
    protected $measurement = array();
    protected $ingredient = array();
    protected $comment = array();
    protected $instructions = array();
    
    public function getAllRecipeTitle($lastUpdated)
    {
        global $db, $logger;
        $mysqli = $db->getMySQLiConnection();
        
        $query = "CALL get_all_recipe_title(?, @recently_added_count);";

        if($stmt = $mysqli->prepare($query))
        {
            $stmt->bind_param("s", $lastUpdated);
            $stmt->execute();

            $stmt->bind_result($title);
            $data = array();

            while($stmt->fetch())
            {
                $data[] = $title;
            }
            
            $stmt->close();
            $logger->logMessage(basename(__FILE__), __LINE__, "getAllRecipeTitle", "CALL get_all_recipe_title({$lastUpdated}, @recently_added_count)");
        }
        else
        {
            $logger->logMessage(basename(__FILE__), __LINE__, "getAllRecipeTitle", "Error in getting all recipe title. error={$mysqli->error}");
        }

        $select = $mysqli->query("SELECT @recently_added_count;");
        $result = $select->fetch_assoc();
        $data['recently_added_count'] = $result['@recently_added_count'];

        $db->closeConnection();

        return $data;
    }

    public function getRecipe($recipe)
    {
        global $db, $logger;
    
        $this->title = $recipe;

        $mysqli = $db->getMySQLiConnection();
        
        $query = "CALL get_recipe(?);"; 
    
        if($stmt = $mysqli->prepare($query))      
        {
            $stmt->bind_param("s", $recipe);
            $stmt->execute();

            $data = array();

            do 
            {
                if($result = $stmt->get_result()) // Retrieves result 3 times
                {
                    $data[] = $result->fetch_all(MYSQLI_ASSOC); // $data[QueryIndex][RowIndexOfTheQuery][ColumnName]
                    $result->free_result();
                }
            }while($stmt->more_results() && $stmt->next_result());

            if(count($data[0]) < 1)
            {
                header("Location: " . BASE_URL . "/Browse_Recipe/?type=My");
                exit;
            }

            // First select query
            $this->category = $data[0][0]['category'];
            $this->preparationTime = $data[0][0]['preparation_time'];
            $this->description = $data[0][0]['description'];
            $this->servings = $data[0][0]['servings'];

            // Second select query
            for($i=0; $i < count($data[1]); $i++)
            {
                $data[1][$i]['quantity'] = $data[1][$i]['quantity'] + 0; // truncates trailing decimal zeros
                $this->quantity[] = $data[1][$i]['quantity'];
                $this->measurement[] = $data[1][$i]['measurement'];
                $this->ingredient[] = $data[1][$i]['ingredient'];
                $this->comment[] =  $data[1][$i]['comment_'];
            }

            // Third select query
            for($i=0; $i < count($data[2]); $i++)
            {
                $this->instructions[] = $data[2][$i]['instruction'];
            }
            
            //combine all ingredients to one array.
            $size = count($this->quantity);
            for($i = 0; $i<$size; $i++) //String treats $this->variable as a variable, but treats [$i] as String. So they must be enclosed in a {} to be treated as an array variable.
            {
                if( empty($this->comment[$i]) )
                {
                    $this->ingredients[] = "{$this->quantity[$i]} {$this->measurement[$i]} {$this->ingredient[$i]}";
                }
                else
                {
                    $this->ingredients[] = "{$this->quantity[$i]} {$this->measurement[$i]} {$this->ingredient[$i]} ({$this->comment[$i]})"; 
                }
            }

            $logger->logMessage(basename(__FILE__), __LINE__, "getRecipe", "CALL get_recipe({$recipe})");
        }    
        else
        {
            $logger->logMessage(basename(__FILE__), __LINE__, "getRecipe", "Error in getting recipe information. error={$mysqli->error}");
        }

        $db->closeConnection();

        return $data;
    }
    
    /**
     * Converts each value of the array to UTF-8
     */
    public function utf8ize($data)
    {
        if(is_array($data))
        {
            foreach($data as $key => $value)
            {
                $data[$key] = $this->utf8ize($value);
            }
        }
        else if(is_string($data))
        {
            return utf8_encode($data);
        }

        return $data;
    }

    abstract protected function showTitle();
    abstract protected function showCategory();
    abstract protected function showPreparationTime();
    abstract protected function showDescription();
    abstract protected function showServings();
    abstract protected function showIngredients();
    abstract protected function showInstructions();
}
?>