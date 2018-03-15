<?php 
ob_start();
require_once(__DIR__ . "/php_scripts/model/User.php");

User::startSession();

if(!User::loggedIn())//check if not logged in 
{
    header("Location: http://{$_SERVER['HTTP_HOST']}/Recipe/Login/");
    exit;
}
?>
<!DOCTYPE html>

<html lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/images/favicon.png" />        
        <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/css/General.css">
    </head>
    
    <body>
     
    <div class="outer">
        <div class="mainContent">

            <img class="headerImage" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/images/header.jpg" alt="Header Image" title="Header" />
     
            <div id="divider">
                <nav>
                    <ul>    
                        <li> <a id="homeLink" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/Home/" class="link">Home</a> </li>
                        <li> <a id="recipeLink" href="#" onClick="return false;">Recipe</a> </li>
                        <li> <a id="ingredientLink" href="#" onClick="return false;">Ingredient</a> </li>
                        <li> 
                            <a id="nameLink" href="#" onClick="return false;"> 
                                <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/images/chef_hat.png" alt="Chef "/>
                                <?php echo User::getUser(); ?> 
                            </a> 
                        </li>
                    </ul>
                    <p class="pclear"></p>
                </nav>
                
                
                <nav id="recipeNavList" class="navList">
                    <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/Browse_Recipe/?type=My&page=1" class="link">My Recipes</a>
                    <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/Submit_Recipe/" class="link">Submit Recipe</a>
                    <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/Browse_Recipe/?type=All&page=1" class="link">Browse Recipes</a>
                </nav>
                
                <nav id="ingredientNavList" class="navList">
                    <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/My_Ingredient/" class="link">My Ingredients</a>
                    <a href="" class="link">Browse Ingredients</a>
                </nav>
                
                <nav id="nameNavList" class="navList">
                    <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/Profile/" class="link">Profile</a>
                    <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/php_scripts/Logout_script.php">Logout</a>
                </nav>
            </div> 