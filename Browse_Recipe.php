<?php include('Header.php'); ?>
 
<?php
require_once(__DIR__  . "/php_scripts/model/RecipeBrowseView.php");

$view = new RecipeBrowseView();
?>
        
    <table id="viewTable">
        <thead>
            <tr>
                <th>Preview</th>
                <th id="orderTitleHeader" >Title &uarr;</th>
                <th id="orderCategoryHeader" >Category<span></span></th>
                    <div id="orderCategoryDiv">
                        <p>All</p>
                        <p>Beef</p>
                        <p>Chicken</p>
                        <p>Pork</p>
                        <p>Lamb</p>
                        <p>Seafood</p>
                        <p>Pasta</p>
                        <p>Vegetable</p>
                        <p>Soup</p>
                        <p>Dessert</p>
                    </div>
                <th>Description</th>
                <th>Author</th>
                <th></th>
            </tr>
        </thead>        
            
        <tbody>
            <?php 
                if( $_GET['type'] == "All" )
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