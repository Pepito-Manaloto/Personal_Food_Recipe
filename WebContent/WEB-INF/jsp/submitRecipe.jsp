<?php include('Header.php'); ?>

    <form action="" method="POST">
            
        <div id="firstRow">
            Title: <input type="text" name="title" id="titleField"/> 
            Preparation time: <input type="text" name="preparationTime" id="timeField"/> minute/s
        </div>
        
        <div id="secondRow">
            Category: <select name="category" id="categoryBox">
                        <option value="Beef">Beef</option>
                        <option value="Chicken">Chicken</option>
                        <option value="Pork">Pork</option>
                        <option value="Lamb">Lamb</option>
                        <option value="Seafood">Seafood</option>
                        <option value="Pasta">Pasta</option>
                        <option value="Vegetable">Vegetable</option>
                        <option value="Soup">Soup</option>
                        <option value="Dessert">Dessert</option>
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