<?php 
ob_start();
require_once(__DIR__ . "/php_scripts/model/User.php");

if( !isset($_SESSION) )
    session_start();

if( User::loggedIn() )//check if already logged in
{
    header("Location: http://{$_SERVER['HTTP_HOST']}/Recipe/Home/");
    exit;
}
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/images/favicon.png" />     
        <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/css/General.css">
        
        <title>Personal Food Recipe - Login</title>
        
    </head>
    
    <body>   
    <div class="outer">
    <div>
        <img class="logo" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/images/recipe_logo.gif" alt="Recipe Exchange" title="Logo" />
        
        <fieldset id="loginArea">
            
            <legend>Login</legend>
            
                <div id="login_error" class="errorMessage">
                </div>
                
                <form action="" method="POST">
                    
                    <p>Username: <input id="username" class="loginField" type="text" maxlength="30"></input> </p>
                    <p>Password: &nbsp;<input id="password" class="loginField" type="password" maxlength="20" /></input> </p>
 
                    <div>
                        <input id="loginButton" type="submit" class="button" value="Login"></input> 
                        <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/images/loader_short.gif" height="20" width="20"/>     
                        <p id="registerParagraph">Do not have an account?   
                            <a class="anchor" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/Register/">Register</a> 
                        </p> 
                    </div>
                </form>
                     
        </fieldset>
<?php include('Footer.php'); ?>