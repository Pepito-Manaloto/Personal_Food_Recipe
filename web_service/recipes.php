<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Recipe/php_scripts/model/RecipeBrowseView.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/Recipe/php_scripts/model/Logger.php");

$headers = apache_request_headers();
global $logger;

$authorization = getAuthorizationHeader($headers);

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
        returnErrorResponseDataAndCode(401, "Unauthorized access.");
    }
}
else
{
      returnErrorResponseDataAndCode(400, "Please provide authorize key.");
}

function getAuthorizationHeader($headers)
{
    if(array_key_exists('Authorization', $headers))
    {
        return isset($headers['Authorization']) ? $headers['Authorization'] : null;
    }
    else if(array_key_exists('authorization', $headers))
    {
        return isset($headers['authorization']) ? $headers['authorization'] : null;
    }
    else
    {
        return null;
    }
}

function returnErrorResponseDataAndCode($code, $errorMessage)
{
    http_response_code($code);
    $error = array("Error" => $errorMessage);
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
    $data["recently_added_count"] = (int) $recipeList["recently_added_count"];
    unset($recipeList["recently_added_count"]);

    $recipeListSize = count($recipeList);
    $logger->logMessage(basename(__FILE__), __LINE__, "GET Recipe", "Recipe count={$recipeListSize}");

    $hostname = $_SERVER['HTTP_HOST'];
    for($i = 0; $i < $recipeListSize; $i++)
    {
        $recipeFromDatabase = $recipeView->getRecipe($recipeList[$i]); // $data[RecipeTitle][QueryIndex][RowIndexOfTheQuery][ColumnName]

        $recipeFromDatabase[0][0]["title"] = $recipeList[$i];
        $data["recipes"][$i] = $recipeFromDatabase[0][0]; // The recipe details
        $data["recipes"][$i]["ingredients"] = $recipeFromDatabase[1]; // The list of ingredients
        $data["recipes"][$i]["instructions"] = $recipeFromDatabase[2]; // The list of instructions

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