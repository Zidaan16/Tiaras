<?php
use App\Http\Route;

Route::get('welcome', function () {

    return response()->json([

        'status' => true,
        'msg' => "Tiara's RestApi"

    ], 200);

});