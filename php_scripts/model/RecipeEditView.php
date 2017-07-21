<?php
require_once(__DIR__ . "/RecipeView.php");
require_once(__DIR__ . "/Recipe.php");

class RecipeEditView extends RecipeView
{
    private $recipe;

    public function __construct()
    {
        $this->recipe = new Recipe();
    }
    
    public function showTitle()
    {
        echo "Title: <input type='text' name='title' id='titleField' value='{$this->title}' />";
    }

    public function showCategory()
    {
        $result = "Category: <select name='category' id='categoryBox'>";
        $categories = $this->recipe->getCategories();
        
        foreach($categories as $c)
        {
            $category = $c->name;
            if($this->category == $category)
            {
                $result .= "<option value='{$category}' selected>{$category}</option>";
            }
            else
            {
                $result .= "<option value='{$category}'>{$category}</option>";
            }
        }

        $result .= "</select>"; 

        echo $result;
    }

    public function showPreparationTime()
    {
        echo "Preparation time: <input type='text' name='preparationTime' id='timeField' value={$this->preparationTime} /> minute/s";
    }

    public function showDescription()
    {
        echo "Description: <textarea name='description' cols='30' rows='4' id='descriptionField'>{$this->description}</textarea>";
    }

    public function showServings()
    {
        echo "Servings: <input type='text' name='servings' id='servingField' value={$this->servings} />";
    }

    public function showIngredients()
    {
        $size = count($this->ingredients);  
        $result = "";
        
        for($i=0; $i < $size; $i++)
        {
            if(empty($this->comment[$i]))
            {
                $comment = "";
            } 
            else 
            {
                $comment = $this->comment[$i];
            }

            $result .= "<div class='ingredientsDiv'>                
                            <span class='spanTab handle'>" . ($i + 1) . "</span>
                            <input type='text' name='quantities[]' class='quantityField' value='{$this->quantity[$i]}' />
                            <input type='text' name='measurements[]' class='measurementField' value='{$this->measurement[$i]}' />
                            <input type='text' name='ingredients[]' class='ingredientField' value='{$this->ingredient[$i]}' />
                            <input type='text' name='comments[]' class='commentField' value='{$comment}' />
                            <input type='button' class='addremoveButton removeIngredient' value='-' />
                        </div>"; 
        }

        echo $result;
    }

    public function showInstructions()
    {
        $size = count($this->instructions);
        $result = "";
        
        for($i=0; $i < $size; $i++)
        {
            $result .= "<div class='instructionsDiv'>
                            <span class='spanTab handle'>" . ($i + 1) . "</span>
                            <textarea name='instructions[]' cols='35' rows='5'>{$this->instructions[$i]}</textarea>
                            <input type='button' class='addremoveButton removeInstruction' value='-' />
                        </div>";
        }   
        
        echo $result;
    }
}
?>