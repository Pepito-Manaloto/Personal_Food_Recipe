<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Recipe/php_scripts/model/Recipe.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/Recipe/php_scripts/model/Logger.php");

$headers = apache_request_headers();
global $logger;

$authorization = isset($headers['Authorization']) ? $headers['Authorization'] : $headers['authorization'];

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
        $logger->logMessage(basename(__FILE__), __LINE__, "GET Categories", "Unauthorized.");
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
?>