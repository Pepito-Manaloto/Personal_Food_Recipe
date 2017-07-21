<?php include('Header.php'); ?>

<?php
require_once(__DIR__ . "/php_scripts/model/Recipe.php");

$recipe = new Recipe();
?>

    <form action="" method="POST">
            
        <div id="firstRow">
            Title: <input type="text" name="title" id="titleField"/> 
            Preparation time: <input type="text" name="preparationTime" id="timeField"/> minute/s
        </div>
        
        <div id="secondRow">
            Category: <select name="category" id="categoryBox">
                        <?php
                            $categories = $recipe->getCategories();
                            
                            foreach($categories as $c)
                            {
                                $category = $c->name;
                                echo "<option value='{$category}'>{$category}</option>";
                            }
                        ?>
                      </select> 
            Servings: <input type="text" name="servings" id="servingField"/>
        </div>   

        <div id="thirdRow">   
            Description: <textarea name="description" cols="30" rows="4" id="descriptionField"></textarea>
        </div>   
                
        <div id="ingredientLabel"> 
            Ingredients: (Quantity Measurement Ingredient Comment) 
            <input type="button" id="addIngredient" class="addremoveButton createAddButtons" value="+"/>
        </div>
    
        <div id="ingredientsContainer">
        
        </div>
        
        <div id="instructionLabel"> 
            Instructions <input type="button" id="addInstruction" class="addremoveButton createAddButtons" value="+"/> 
        </div>
        
        <div id="instructionsContainer">

        </div>
        
        <div id="createValidateDiv"></div>

        <div id="continueButtonDiv">
            <input id="continueButton" type="submit" value="Continue" class="button"/>
        </div>
        
    </form>

<?php include('Footer.php'); ?>