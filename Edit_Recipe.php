<?php include('Header.php'); ?>

<?php
require_once(__DIR__ . "/php_scripts/model/RecipeEditView.php");

if(isset($_GET['title']))
{
    $view = new RecipeEditView();
    $view->getRecipe($_GET['title']);

    $_SESSION['editTitle'] = $_GET['title']; //get title for reference, if the title is renamed after editing.
}
else
{
    header("Location: http://{$_SERVER['HTTP_HOST']}/Recipe/Browse_Recipe/?type=My");
    exit;
}
?>

    <form action="" method="POST">

        <div id="firstRow">
            <?php
                $view->showTitle();
                $view->showPreparationTime();
            ?>
        </div>

        <div id="secondRow">
            <?php
                $view->showCategory();
                $view->showServings();
            ?>
        </div>

        <div id="thirdRow">
            <?php
                $view->showDescription();
            ?>
        </div>

        <div id="ingredientLabel">
            Ingredients: (Quantity Measurement Ingredient Comment)
            <input type="button" id="addIngredient" class="addremoveButton" value="+"/>
        </div>

        <div id="ingredientsContainer">
            <?php
                $view->showIngredients();
            ?>
        </div>

        <div id="instructionLabel">
            Instructions <input type="button" id="addInstruction" class="addremoveButton" value="+"/>
        </div>

        <div id="instructionsContainer">
            <?php
                $view->showInstructions();
            ?>
        </div>

        <div id="createValidateDiv"></div>

        <div id="continueButtonDiv">
            <input id="editButton" type="submit" value="Continue" class="button"/>
        </div>

    </form>

<?php include('Footer.php'); ?>