<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Recipe/php_scripts/model/Recipe.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/Recipe/php_scripts/model/Logger.php");

$headers = apache_request_headers();
global $logger;

$authorization = getAuthorizationHeader($headers);

if(isset($authorization))
{
    $isAuthorized = $authorization === md5("aaron");
    if($isAuthorized)
    {
        $recipe = new Recipe();
        $data = json_encode($recipe->getCategories());

        http_response_code(200); // OK

        $logger->logMessage(basename(__FILE__), __LINE__, "GET Categories", "Authenticated. categories={$data}");

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
?>