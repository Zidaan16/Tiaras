<?php
use System\App;
use System\Container;
use System\Database\Connection;
use System\Routing\RouteCollection;

class Console {

    private $version;
    private $countUri = [];
    private $countMethod = [];
    private $countController = [];
    private $countName = [];
    private $http = [];
    private $uri = [];
    private $controller = [];
    private $method = [];
    private $name = [];


    public function __construct()
    {
        echo "\n\e[1;37mTiara's\e[0m v1, ",date('d M Y').PHP_EOL.PHP_EOL;
        $this->checkCompatibility();
    }

    public function handle($argv)
    {
        if (empty($argv[1])) $this->help();

        switch ($argv[1]) {
            case 'start':
                system("php -S localhost:8000 -C php.ini -t public/");
                break;
            
            case 'list:route':
                $this->list('route');
                break;

            case 'make:controller':
                $this->makeController($argv);
                break;
            
            case 'make:model':
                $this->makeModel($argv);
                break;

            case 'make:middleware':
                $this->makeMiddleware($argv);
                break;

            case 'make:migration':
                $this->makeMigration($argv);
                break;

            case 'migrate:drop':
                $this->dropMigration($argv);
                break;

            case 'migration':
                $this->migration();
                break;
            
            case 'help':
                $this->help();
                break;
            
            default:
                $this->help();
                break;
        }
    }

    private function help()
    {
        $arr = [
            "start" => "running PHP built-in web server",
            "make:controller" => "creating a new controller file (App/Controller)",
            "make:model" => "creating a new model file (App/Model)",
            "make:migrate" => "creating a new migration file (App/Migration)",
            "make:middleware" => "creating a new middleware file (App/Middleware)",
            "migration" => "migrations file in App/Migration",
            "migrate:drop" => "drop a specific migration",
            "list:route" => "lists of route"
        ];
        foreach ($arr as $key => $value) {
            printf("%-29s$value\n", "\e[1;32m$key\e[0m");
        }
        exit;
    }

    private function list(String $list)
    {
        switch ($list) {
            case 'route':
                $this->showRoute();
                break;
        }
    }

    private function showRoute()
    {
        if (empty(RouteCollection::get())) die('Nothing to show up');

        foreach (RouteCollection::get() as $key) {
            if (!empty($key['http'])) $this->http[] = $key['http'];
            if (!empty($key['uri'])) $this->uri[] = $key['uri'];
            $this->countUri[] = strlen($key['uri']);

            if (!empty($key['controller'])) {
                $this->controller[] = $key['controller'];
                $this->countController[] = strlen($key['controller']);
            }else {
                $this->controller[] = null;
            }
            
            if (!empty($key['method'])) {
                if (is_callable($key['method'])) {
                    $this->method[] = "Closure";
                    $this->countMethod[] = strlen("Closure");
                }else {
                    $this->method[] = $key['method'];
                    $this->countMethod[] = strlen($key['method']);
                }
            } else {
                $this->method[] = null;
            }
            
            if (!empty($key['name'])) {
                $this->name[] = $key['name'];
                $this->countName[] = strlen($key['name']);
            }else {
                $this->name[] = null;
            }
                
        }
        $padding1 = (!empty($this->countUri)) ? 3 + max($this->countUri) : 3;
        $padding2 = (!empty($this->countMethod)) ? 3 + max($this->countMethod) : 3;
        $padding3 = (!empty($this->countName)) ? 3 + max($this->countName) : 7;
        

        // header
        echo str_pad("NO", 6, ' ', STR_PAD_RIGHT);
        echo str_pad("HTTP", 9, ' ', STR_PAD_RIGHT);
        echo str_pad("URI", $padding1, ' ', STR_PAD_RIGHT);
        echo str_pad("Name", $padding3, ' ', STR_PAD_RIGHT);
        echo str_pad("METHOD", $padding2, ' ', STR_PAD_RIGHT).PHP_EOL;
        echo PHP_EOL;
        $no = 0;

        for ($i=0; $i < count($this->uri); $i++) { 
            $no++;
            if ($this->controller[$i] != null) {
                $controller = explode('\\', $this->controller[$i]);
                $controllerMethod = end($controller)."::".$this->method[$i];
            } else {
                $controllerMethod = $this->method[$i];
            }

            // body
            echo str_pad($no, 6, ' ', STR_PAD_RIGHT);
            echo str_pad($this->http[$i], 9, ' ', STR_PAD_RIGHT);
            echo str_pad($this->uri[$i], $padding1, ' ', STR_PAD_RIGHT);
            echo str_pad($this->name[$i], $padding3, ' ', STR_PAD_RIGHT);
            echo str_pad($controllerMethod, $padding2, ' ', STR_PAD_RIGHT).PHP_EOL;
        }
    }

    private function log(String $msg)
    {
        file_put_contents('Trash/console_log.txt', $msg, FILE_APPEND);
    }

    private function loadEnv()
    {
        // load env
        $file = ".env";
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
    }

    private function dropMigration($file)
    {
        if (empty($file[2])) die($this->showFailed('Migration filename cannot be empty'));

        $this->showTask('Dropping migration ');
        require_once "App/Migration/$file[2]";
        $class = str_replace('.php', '', $file[2]);
        $class = "\App\Database\Migration\\$class";
        call_user_func([new $class, 'down']);

        if (Application\Signal::$result) {

            $this->showSuccess("\e[1;37m$file[2]\e[0m");
            $this->log("[".time()."] Dropped migration $file[2]".PHP_EOL);

        } else {

            $this->showFailed("\e[1;37m$file[2]\e[0m");
            $this->log("[".time()."] Failed Dropped migration $file[2]".PHP_EOL);

        }
    }

    private function migration()
    {
        $this->showTask('Running migrations');
        $dir = scandir('App/Migration');
        $c = array_splice($dir, 2, 2);
        
        for ($i=0; $i < count($c); $i++) { 
            require_once "App/Migration/$c[$i]";
            $class = str_replace('.php', '', $c[$i]);
            $class = "\App\Database\Migration\\$class";
            
            call_user_func([new $class, 'up']);

            if (Application\Signal::$result) {

                $this->showSuccess("\e[1;37m$c[$i]\e[0m");
                $this->log("[".time()."] Migrated $c[$i]".PHP_EOL);

            } else {

                $this->showFailed("\e[1;37m$c[$i]\e[0m");
                $this->log("[".time()."] Failed Migrated $c[$i]".PHP_EOL);

            }
        }

    }

    private function makeMiddleware($name)
    {
        if (empty($name[2])) die($this->showFailed('Migration name cannot be empty'));
        $this->showTask("Create Middleware");
        $this->create("System/Application/", $name[2], "Middleware");
    }

    private function makeMigration($name)
    {
        if (empty($name[2])) die($this->showFailed('Migration name cannot be empty'));
        $this->showTask("Create Migration");
        $this->create("System/Application/", $name[2], "Migration");
    }

    private function makeModel($name)
    {

        if (empty($name[2])) die($this->showFailed('Model name cannot be empty'));
        $contain = (str_contains($name[2], 'Model')) ? true : false;

        switch ($contain) {
            case true:
                $this->showTask("Create Model");
                $this->create("System/Application/", $name[2], "Model");
                break;

            case false:
                $this->showTask("Create Model");
                $this->create("System/Application/", $name[2]."Model", "Model");
                break;
            
                
        }
    }

    private function makeController($name)
    {
        if (empty($name[2])) die($this->showFailed('Controller name cannot be empty'));

        $contain = (str_contains($name[2], 'Controller')) ? true : false;

        switch ($contain) {
            case true:
                $this->showTask('Create Controller');
                $this->create("System/Application/", $name[2], "Controller");
                break;

            case false:
                $this->showTask('Create Controller');
                $this->create("System/Application/", $name[2]."Controller", "Controller");
                break;
            
                
        }

    }

    private function create($path, $className, $type)
    {
        $controller = fopen("$path/$type/$type.txt", 'r');

        while (!feof($controller)) {

            $line = fgets($controller);
            $line = str_replace('REPLACE_ME', $className, $line);
            file_put_contents("Trash/$className.temp", $line, FILE_APPEND);
        }
        fclose($controller);

        if (copy("Trash/$className.temp", "App/$type/$className.php")) {
            $this->showSuccess("\e[1;37m$className.php\e[0m");
            $this->log("[".time()."] Create $type $className.php".PHP_EOL);
        } else {
            $this->showFailed("\e[1;37m$className.php\e[0m");
            $this->log("[".time()."] Failed Create $type $className.php".PHP_EOL);
        }

        unlink("Trash/$className.temp");

    }

    private function showTask(String $string)
    {
        $string = "[\e[1;37m#\e[0m] \e[1;37m".$string."\e[0m".PHP_EOL;
        printf("%47s\n", $string);
    }

    private function showSuccess(String $string)
    {
        $percent = 122;
        $count = strlen($string);
        $final = $percent-$count;
        printf("$string%'.".$final."s\n", "\e[1;32mSUCCESS\e[0m");
    }

    private function showFailed(String $string)
    {
        $percent = 122;
        $count = strlen($string);
        $final = $percent-$count;
        printf("$string%'.".$final."s\n", "\e[1;31mFAILED\e[0m");
    }

    private function checkCompatibility()
    {
        $this->loadJson();
        $this->loadEnv();
        echo ($this->version > phpversion('Core')) ? "Your php version is not compatible (expect \e[1;32m".$this->version."\e[0m), please upgrade your php version".PHP_EOL.PHP_EOL : PHP_EOL;
    }

    private function loadJson()
    {
        $file = file_get_contents('Tiaras.json');
        $json = json_decode($file, true);

        $this->version = $json['app']['require']['php'];
    }

    private function version()
    {
        echo 'version';
    }

}

