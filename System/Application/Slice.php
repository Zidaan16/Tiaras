<?php
namespace System\Feature;

class Slice {

    public static function whenMethodString($method)
    {
        return [
            'method' => $method
        ];
    }

    public static function whenMethodArray($method)
    {
        return [
            'class' => $method[0],
            'method' => $method[1]
        ];
    }

}