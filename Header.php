<?php 
ob_start();
require_once("{$_SERVER['DOCUMENT_ROOT']}/Recipe/php_scripts/model/User.php");

if( !isset($_SESSION) )
    session_start();
    
if( !User::loggedIn() )//check if not logged in 
{
    header("Location: http://localhost/Recipe/Login/");
    exit;
}
?>
<!DOCTYPE html>

<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="http://localhost/Recipe/images/favicon.png" />        
        <link rel="stylesheet" type="text/css" href="http://localhost/Recipe/css/General.css">
    </head>
    
    <body>      
     
    <div class="outer"> 
        <div class="mainContent">

            <img class="headerImage" src="http://localhost/Recipe/images/header.jpg" alt="Header Image" title="Header" />
     
            <div id="divider">
                <nav>
                    <ul>    
                        <li> <a id="homeLink" href="http://localhost/Recipe/Home/" class="link">Home</a> </li>
                        <li> <a id="recipeLink" href="#" onClick="return false;">Recipe</a> </li>
                        <li> <a id="ingredientLink" href="#" onClick="return false;">Ingredient</a> </li>
                        <li> 
                            <a id="nameLink" href="#" onClick="return false;"> 
                                <img src="http://localhost/Recipe/images/chef_hat.png" alt="Chef "/>
                                <?php echo User::getUser(); ?> 
                            </a> 
                        </li>
                    </ul>
                    <p class="pclear"></p>
                </nav>
                
                
                <nav id="recipeNavList" class="navList">
                    <a href="http://localhost/Recipe/Browse_Recipe/?type=My&page=1" class="link">My Recipes</a>
                    <a href="http://localhost/Recipe/Submit_Recipe/" class="link">Submit Recipe</a>
                    <a href="http://localhost/Recipe/Browse_Recipe/?type=All&page=1" class="link">Browse Recipes</a>
                </nav>
                
                <nav id="ingredientNavList" class="navList">
                    <a href="http://localhost/Recipe/My_Ingredient/" class="link">My Ingredients</a>
                    <a href="" class="link">Browse Ingredients</a>
                </nav>
                
                <nav id="nameNavList" class="navList">
                    <a href="http://localhost/Recipe/Profile/" class="link">Profile</a>
                    <a href="http://localhost/Recipe/php_scripts/Logout_script.php">Logout</a>
                </nav>
            </div> 