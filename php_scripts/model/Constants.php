<?php
define("BASE_URL", "http://{$_SERVER['HTTP_HOST']}/Recipe");
define("BASE_DIR", "{$_SERVER['DOCUMENT_ROOT']}/Recipe");
define("LOG_DIR", BASE_DIR . "/log");
define("LOG_FILE", "/recipe.log." . date("Y-m-d"));
define("IMAGE_DIR", BASE_DIR . "/images");
define("RECIPE_IMAGE_DIR", IMAGE_DIR . "/recipe_images");
define("PDF_DIR", BASE_DIR . "/pdf");
define("BACKUP_DIR", BASE_DIR . "/backup");
?>