<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Recipe/php_scripts/model/Recipe.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/Recipe/php_scripts/model/Logger.php");

$headers = apache_request_headers();
global $logger;

if(isset($headers['Authorization']))
{
    if($headers['Authorization'] === md5("aaron"))
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
        echo "Unauthorized access.";
    }
}
else
{
    http_response_code(400); // Bad Request
    echo "Please provide authorize key.";
}
?>