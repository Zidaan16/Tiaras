<?php
require_once 'System/App.php';
require_once 'System/Container/Container.php';
require_once 'System/Application/Collection.php';
require_once 'System/Database/Connection.php';
require_once 'System/Console/Signal.php';
require_once 'System/Database/Paper/Paper.php';
require_once 'System/Database/DB.php';
require_once 'System/Database/Trait/ForgeAttr.php';
require_once 'System/Database/Forge.php';
require_once 'System/Console/Console.php';
require_once 'App/Middleware/Middleware.php';
require_once 'System/Http/Request.php';
require_once 'System/Http/Response.php';
require_once 'System/Routing/RouteCollection.php';
require_once 'System/Routing/Trait/Dispatcher.php';
require_once 'System/Http/Httpkernel.php';
require_once 'System/Container/Route/RouteContainer.php';
require_once 'System/Routing/RouteHandler.php';
require_once 'System/Routing/Route.php';
require_once 'Routes/web.php';

\Application\Signal::service(true);
require_once 'Routes/api.php';

$console = new Console();
$console->handle($argv);
