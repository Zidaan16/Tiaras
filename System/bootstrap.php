<?php
use System\Container;
use System\Database\Connection;

// load env
$file = "../.env";
$open = fopen($file, 'r');
while (!feof($open)) {
    
    $explode = explode('=', fgets($open));
    if (!empty($explode[1]))
    {
        $clear = trim($explode[1]);
        $_ENV[$explode[0]] = $clear;
    }

}
fclose($open);

$container = new Container;
// create connection to database
$container->bind('System\Database\Connection', function () {

    $connection = new Connection;
    return $connection->create($_ENV['DB_NAME'], $_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS']);

});

// load feature
$container->bind('Load\Feature', function () {

    require_once 'Feature/view.php';

});


// register container
\System\App::setContainer($container);

// resolve container
\System\App::container('Load\Feature');