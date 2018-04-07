<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/Recipe/php_scripts/model/Recipe.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/Recipe/php_scripts/model/Logger.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/Recipe/php_scripts/model/WebServiceUtils.php");

$webServiceUtils = new WebServiceUtils();
global $logger;

$result = $webServiceUtils->authenticate();

if($result == 200)
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
    if($result == 401)
    {
        $webServiceUtils->returnErrorResponseDataAndCode(401, "Unauthorized access.");
    }
    else if($result == 400)
    {
        $webServiceUtils->returnErrorResponseDataAndCode(400, "Please provide authorize key.");
    }
}
?>