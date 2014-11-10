<?php
require_once(__DIR__ . "/RecipeView.php");
require_once(__DIR__ . "/User.php");
    
class RecipeBrowseView extends RecipeView
{   
    private $author;
    public static $limit = 7.0;
    private $pageNumber;
    private $orderBy;
    private $sortCategory;
    private $imagePath;

    public function __construct($page = 1, $order = "Asc", $cat = "All")
    {
        $this->pageNumber = ($page-1) * RecipeBrowseView::$limit;
        $this->orderBy = $order;
        $this->sortCategory = $cat;
        $this->imagePath = "http://{$_SERVER['HTTP_HOST']}/Recipe/images/recipe_images/{$this->title}.jpg";
        
        if(!file_exists($this->imagePath))
        {
            $this->imagePath = "http://{$_SERVER['HTTP_HOST']}/Recipe/images/default.jpg";
        }
    }
    
    public function populateBrowseRecipe()
    {
        global $db;
    
        $mysqli = $db->getMySQLiConnection();
    
        $query = "CALL show_all_recipe(?,?,?,?);";   

        if( $stmt = $mysqli->prepare($query) )      
        {
            $stmt->bind_param("ssii", $this->sortCategory, $this->orderBy, self::$limit, $this->pageNumber); 
            $stmt->execute();
    
            $stmt->bind_result($this->title, $this->category, $this->description, $this->author);

            while( $stmt->fetch() )
            {
                echo
                    "<tr>
                        <td>
                            <img src='{$this->imagePath}' width='250' height='190' alt='{$this->title}' />
                        </td> 
                        <td>{$this->title}</td> 
                        <td>{$this->category}</td> 
                        <td>{$this->description}</td> 
                        <td>{$this->author}</td>
                        <td>
                            <a class='anchor' href='http://{$_SERVER['HTTP_HOST']}/Recipe/View_Recipe/?title={$this->title}'>View More</a>
                        </td>
                    </tr>";
            }
        }
        
        $db->closeConnection();
    }

    public function populateMyRecipe()
    {
        global $db;

        $mysqli = $db->getMySQLiConnection();
        
        $query = "CALL show_recipe(?,?,?,?,?);";    
    
        if( $stmt = $mysqli->prepare($query) )      
        {
            $this->author = User::getUser();    
                    
            $stmt->bind_param("sssii", $this->author, $this->sortCategory, $this->orderBy, self::$limit, $this->pageNumber);
            $stmt->execute();

            $stmt->bind_result($this->title,$this->category,$this->description);
            
            while( $stmt->fetch() )
            {
                echo
                    "<tr>
                        <td>
                            <img src='{$this->imagePath}' width='250' height='190' alt='{$this->title}' />
                        </td> 
                        <td>{$this->title}</td> 
                        <td>{$this->category}</td> 
                        <td>{$this->description}</td> 
                        <td>{$this->author}</td>
                        <td>
                            <a class='anchor' href='http://{$_SERVER['HTTP_HOST']}/Recipe/View_Recipe/?title={$this->title}'>View More</a>
                            <a class='anchor' href='http://{$_SERVER['HTTP_HOST']}/Recipe/Edit_Recipe/?title={$this->title}'>Edit</a>
                            <a class='anchor' id='deleteLink' href='#'>Delete</a>
                        </td>
                    </tr>";
            }
        }
        
        $db->closeConnection();
    }
    
    public function populatePagination($type="My")
    {
        global $db;
        
        $mysqli = $db->getMySQLiConnection();
        
        $query = "CALL get_recipe_count(?,?);"; 

        if( $stmt = $mysqli->prepare($query) )      
        {
            if($type == "My")
            {
                $this->author = User::getUser();    
            }
            else
            {
                $this->author = "";
            }
            
            $stmt->bind_param("ss", $this->author, $this->sortCategory);
            $stmt->execute();

            $stmt->bind_result($total);
            $stmt->fetch();
        
            $totalNumber = ceil( $total / self::$limit);
            
            echo "<span>1</span> ";
            
            for($i=2; $i <= $totalNumber ; $i++)
            {
                echo "<a href='#'>{$i}</a> ";
            }
        }
        
        $db->closeConnection();
    }
    
    public function changeImage()
    {
        if( !empty($_FILES["image"]['name']) )
        {
            $image_path = Paths::IMAGE_PATH . "/{$this->title}.jpg";

            if($_FILES["image"]["type"] == "image/jpg" || $_FILES["image"]["type"] == "image/jpeg") 
            {
                if( file_exists($image_path) )
                {
                    unlink($image_path);
                }
                @move_uploaded_file( $_FILES['image']['tmp_name'], $image_path);    
            }           
        }   
    }
    
    public function showTitle()
    {
        echo $this->title;
    }
    
    public function showImage()
    {
        echo $this->imagePath;
    }
    public function showCategory()
    {
        echo $this->category;
    }
    public function showPreparationTime()
    {
        echo $this->preparationTime;
    }
    public function showDescription()
    {
        echo $this->description;
    }
    public function showServings()
    {
        echo $this->servings;
    }
    
    public function showIngredients()
    {
        $size = count($this->ingredients);

        for($i=0; $i < $size; $i++)
        {
            echo "<p>{$this->ingredients[$i]}</p>";
        }
    }

    public function showInstructions()
    {
        $size = count($this->instructions);
        
        for($i=0, $j=1; $i < $size; $i++,$j++)
        {
            echo "<p>{$j}. {$this->instructions[$i]} </p>";
        }
    }
}
?>