<?php ob_start(); ?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/images/favicon.png" />   
        <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/css/General.css">
        
        <title>Personal Food Recipe - Register</title>   
    </head>
    
    <body>
    
    <div class="outer">  
    <div>
        <img class="logo" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/images/recipe_logo.gif" alt="Recipe Exchange" title="Logo"/>

        <fieldset id="registerArea">
            
            <legend>Register</legend>
            
            <div id="register_error">
            </div>

            <form id="registerForm" action="" method="POST">
                
                <p>Username: <input id="username" type="text" maxlength="30"/> </p>
                <p>Password: <input id="password" type="password" maxlength="20"/> </p>
                <p>Confirm Password: <input id="confirmPassword" type="password" maxlength="20"/> </p>
    
                <div>
                    <a class="anchor" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/Login/">back</a>
                    <input id="registerButton" type="submit" class="button" value="Register"/> 
                    <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/images/loader_short.gif" height="20" width="20"/>
                </div>   
            </form>
            
        </fieldset> 
    
<?php include('Footer.php'); ?>