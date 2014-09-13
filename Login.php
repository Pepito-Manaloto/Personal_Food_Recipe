<?php 
ob_start();
require_once("{$_SERVER['DOCUMENT_ROOT']}/Recipe/php_scripts/model/User.php");

if( !isset($_SESSION) )
    session_start();

if( User::loggedIn() )//check if already logged in
{
    header("Location: http://localhost/Recipe/Home/");
    exit;
}
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="http://localhost/Recipe/images/favicon.png" />     
        <link rel="stylesheet" type="text/css" href="http://localhost/Recipe/css/General.css">
        
        <title>Personal Food Recipe - Login</title>      
        
    </head>
    
    <body>   
    <div class="outer">
    <div>
        <img class="logo" src="http://localhost/Recipe/images/recipe_logo.gif" alt="Recipe Exchange" title="Logo" />
        
        <fieldset id="loginArea">
            
            <legend>Login</legend>
            
                <div id="login_error" class="errorMessage">
                </div>
                
                <form action="" method="POST">
                    
                    <p>Username: <input id="username" class="loginField" type="text" maxlength="30"></input> </p>
                    <p>Password: &nbsp;<input id="password" class="loginField" type="password" maxlength="20" /></input> </p>
 
                    <div>
                        <input id="loginButton" type="submit" class="button" value="Login"></input> 
                        <img src="http://localhost/Recipe/images/loader_short.gif" height="20" width="20"/>     
                        <p id="registerParagraph">Do not have an account?   
                            <a class="anchor" href="http://localhost/Recipe/Register/">Register</a> 
                        </p> 
                    </div>
                </form>
                     
        </fieldset>
<?php include('Footer.php'); ?>