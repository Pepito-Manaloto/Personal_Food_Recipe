<?php include('Header.php'); ?>

<?php
require_once(__DIR__ . "/php_scripts/model/RecipeBrowseView.php");
require_once(__DIR__ . "/php_scripts/model/Recipe.php");

$view = new RecipeBrowseView();
$recipe = new Recipe();
?>
        
    <table id="viewTable">
        <thead>
            <tr>
                <th>Preview</th>
                <th id="orderTitleHeader" >Title &uarr;</th>
                <th id="orderCategoryHeader" >Category<span></span></th>
                    <div id="orderCategoryDiv">
                        <p>All</p>
                        <?php
                            $categories = $recipe->getCategories();
                            
                            foreach($categories as $c)
                            {
                                $category = $c->name;
                                echo "<p>{$category}</p>";
                            }
                        ?>
                    </div>
                <th>Description</th>
                <th>Author</th>
                <th></th>
            </tr>
        </thead>
            
        <tbody>
            <?php
                if($_GET['type'] == "All")
                    $view->populateBrowseRecipe(); 
                else if($_GET['type'] == "My" ) 
                    $view->populateMyRecipe(); 
                else
                    header("Location: http://{$_SERVER['HTTP_HOST']}/Recipe/404/");
            ?>
        </tbody>
        
    </table>
    
    <div id="viewPaginationDiv">
        <?php
            if( $_GET['type'] == "All" || $_GET['type'] == "My" )
                $view->populatePagination($_GET['type']);
            else
                header("Location: http://{$_SERVER['HTTP_HOST']}/Recipe/404/");
        ?>
    </div>
    
<?php include('Footer.php'); ?> 