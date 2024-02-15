<?php
namespace System\Http;
use App\Http\Request;
use App\Http\Response;
use App\Middleware;
use System\Routing\Dispatcher;

class Httpkernel extends Middleware{

    use Dispatcher;

}