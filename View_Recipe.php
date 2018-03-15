<?php include('Header.php'); ?>

<?php
//header("Cache-Control: no-cache");

require_once(__DIR__ . "/php_scripts/model/RecipeBrowseView.php");

if(isset($_GET['title']))
{
    $view = new RecipeBrowseView();
    $view->getRecipe($_GET['title']);

    if(isset($_POST['submit']))
    {
        $view->changeImage();
        header("Location: http://{$_SERVER['HTTP_HOST']}/Recipe/View_Recipe/?title={$_GET['title']}");
        exit;
    }
}
else
{
    header("Location: http://{$_SERVER['HTTP_HOST']}/Recipe/Browse_Recipe/?type=My");
    exit;
}

?>

    <div class="recipeContent"> 
        <img src="<?php $view->showImage(); ?>" width="280" height="230" alt="preview"/>

        <form action="" method="POST" enctype="multipart/form-data" id="imageForm">
            <input type="file" name="image" id="changeImage" />
            <a href="#" class="anchor" onClick="document.getElementById('changeImage').click(); return false;">Change Image</a>
            <input type="submit" name="submit" value="^" />
        </form>
    </div>

    <div id="infoDiv">
        <p>Title: <?php $view->showTitle(); ?></p>
        <p>Category: <?php $view->showCategory(); ?></p>
        <p>Preparation Time: <?php $view->showPreparationTime(); ?> minute/s</p>
        <p>Servings: <?php $view->showServings(); ?></p>
        <p>Description: <?php $view->showDescription(); ?></p>
    </div>

    <p class="pclear"></p>

    <div id="recipeIngredientsDiv" class="recipeContent">
        Ingredients:
        <?php $view->showIngredients(); ?>
    </div>

    <div id="recipeInstructionsDiv" class="recipeContent">
        Instructions:
        <?php $view->showInstructions(); ?>
    </div>

    <p class="pclear"></p>

    <form action="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/php_scripts/DownloadRecipe_script.php?title=<?php $view->showTitle(); ?>.pdf" method="POST" id="submitForm">
        <input type="submit" id="downloadPdfButton" value="Save as PDF" class="button" />
    </form>

<?php include('Footer.php'); ?>