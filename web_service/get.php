<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/Recipe/php_scripts/model/RecipeBrowseView.php");

$headers = apache_request_headers();

if(isset($headers['Authorization']))
{
    if($headers['Authorization'] === md5("aaron"))
    {
        if(!isset($_GET['last_updated']) || empty($_GET['last_updated'])) // If last_updated is not given, then set earliest date
        {
            $lastUpdated = "1950-01-01";
        }
        else
        {
            $lastUpdated = $_GET['last_updated'];
        }

        $data = get($lastUpdated);

        http_response_code(200); // OK

        header('Content-Type: application/json');
        echo $data;
    }
    else
    {
        http_response_code(401); // Unauthorized
        echo "Unauthorized access.";
    }
}
else
{
    http_response_code(400); // Bad Request
    echo "Please provide authorize key.";
}

/**
 * QueryIndex -  0 is Recipe information
 *               1 is ingredients
 *               2 is instructions
 *               3 is the encoded binary image
 */
function get($lastUpdated)
{
    $recipeView = new RecipeBrowseView();

    $recipeList = $recipeView->getAllRecipeTitle($lastUpdated);

    $data = array();
    $data["recently_added_count"] = $recipeList["recently_added_count"];

    unset($recipeList["recently_added_count"]);
    $recipeListSize = count($recipeList);

    for($i = 0; $i < $recipeListSize; $i++)
    {
        $data[$recipeList[$i]] = $recipeView->getRecipe($recipeList[$i]); // $data[RecipeTitle][QueryIndex][RowIndexOfTheQuery][ColumnName]

        $imagePath = "http://{$_SERVER['HTTP_HOST']}/Recipe/images/recipe_images/{$recipeList[$i]}.jpg";
        
        if(!file_exists($imagePath))
        {
            $imagePath = "http://{$_SERVER['HTTP_HOST']}/Recipe/images/default.jpg";
        }

        //$data[$recipeList[$i]][] = base64_encode(file_get_contents($imagePath));
    }

    return json_encode($data);
}

?>