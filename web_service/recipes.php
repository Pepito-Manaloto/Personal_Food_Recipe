<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Recipe/php_scripts/model/RecipeBrowseView.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/Recipe/php_scripts/model/Logger.php");

$headers = apache_request_headers();
global $logger;

$authorization = isset($headers['Authorization']) ? $headers['Authorization'] : $headers['authorization'];

if(isset($authorization))
{
    $isAuthorized = $authorization === md5("aaron");
    if($isAuthorized)
    {
        $hasLastUpdatedHeader = isset($_GET['last_updated']) && !empty($_GET['last_updated']);

        if($hasLastUpdatedHeader)
        {
            $lastUpdated = $_GET['last_updated'];
        }
        else
        {
            $lastUpdated = "1950-01-01"; // If last_updated is not given, then set earliest date
        }

        $logger->logMessage(basename(__FILE__), __LINE__, "GET Recipe", "Authenticated. Get by last_updated={$lastUpdated}");

        $data = get($lastUpdated);

        http_response_code(200); // OK

        header('Content-Type: application/json');
        echo $data;
    }
    else
    {
        http_response_code(401); // Unauthorized
        $error = array("Error" => "Unauthorized access.");
        echo json_encode($error);
    }
}
else
{
    http_response_code(400); // Bad Request
    $error = array("Error" => "Please provide authorize key.");
    echo json_encode($error);
}

/**
 * QueryIndex -  0 is Recipe information
 *               1 is ingredients
 *               2 is instructions
 *               3 is the encoded binary image
 */
function get($lastUpdated)
{
    global $logger;
    $recipeView = new RecipeBrowseView();

    $recipeList = $recipeView->getAllRecipeTitle($lastUpdated);

    $data = array();
    $data["recently_added_count"] = $recipeList["recently_added_count"];

    unset($recipeList["recently_added_count"]);
    $recipeListSize = count($recipeList);

    $logger->logMessage(basename(__FILE__), __LINE__, "GET Recipe", "Recipe count={$recipeListSize}");

    $hostname = $_SERVER['HTTP_HOST'];
    for($i = 0; $i < $recipeListSize; $i++)
    {
        $data[$recipeList[$i]] = $recipeView->getRecipe($recipeList[$i]); // $data[RecipeTitle][QueryIndex][RowIndexOfTheQuery][ColumnName]

        $imagePath = "http://{$hostname}/Recipe/images/recipe_images/{$recipeList[$i]}.jpg";
        
        if(!file_exists($imagePath))
        {
            $imagePath = "http://{$hostname}/Recipe/images/default.jpg";
        }

        //$data[$recipeList[$i]][] = base64_encode(file_get_contents($imagePath));
    }

    return json_encode($data);
}

?>