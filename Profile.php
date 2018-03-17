<?php include('Header.php'); ?>
<?php 
    require_once(__DIR__ . "/php_scripts/model/User.php");

    $user = new User();
?>
    <h1>Profile</h1>

    <div id="profileDiv">
        <p>Username: <?php echo User::getUser(); ?> <a id ="profileEditLink" class="profileLinks" href="#">Edit</a> </p> 
        <p>Number of Recipes: <?php echo $user->getRecipeCount(); ?> <a id= "profileExpandLink" class="profileLinks" href="#">Expand</a> </p> 
            <ul id="profileRecipeList" class="profileLists">
                <?php echo $user->showRecipeCountByCategory(); ?>
            </ul>

        <p>Number of Ingredients: <a class="profileLinks" href="#">Expand</a> </p>
        
        <form action="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/php_scripts/CreateBackup.php" method="POST" id="submitForm">
            <input id="backupButton" type="submit" class="button" value="Create Backup"/> 
        </form>
    </div>

    <div id="editProfileDiv">
        <form action="" method="POST">
            <p>Username: <input id="username" type="text" name="profileName" maxlength="30"/> </p>
            <p>Password: <input id="password" type="password" name="profilePassword" maxlength="20"/></p>
            <p>Confirm Password: <input id="confirmPassword"  type="password" maxlength="20"/></p>
            <p>Note: Leave password empty if you do not want to change password.</p>
            <span>
                <div id="editProfileValidateDiv"></div>
                <input id="editProfileButton" class="button" type="submit" value="Continue"/>
            </span>

            <input id="editProfileExit" type="button" class="button" value="X"/>
        </form>
    </div>

    <div id="editProfileShadow"></div>

<?php include('Footer.php'); ?> 
