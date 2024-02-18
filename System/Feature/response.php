<?php

class SetResponse {

    private $request;
    private $httpCode;
    private $data;

    public function __construct(\App\Http\Request $request)
    {
        $this->request = $request;
    }

    public function json(Array $data, Int $http = 200)
    {
        $this->httpCode = $http;
        $this->request->header('Content-Type: application/json; charset=utf-8');
        $this->data = json_encode($data);
        return $this;
    }

    public function __destruct()
    {
        http_response_code($this->httpCode);
        echo $this->data;
    }

}

function response($httpCode = null)
{
    if ($httpCode == null) return new SetResponse(new \App\Http\Request);
    else http_response_code($httpCode);
}