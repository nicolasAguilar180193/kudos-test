<?php

use App\Http\Middleware\TestMiddleware;
use App\Services\Transistor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class Service
{
    function __construct(){}

    function sayHello()
    {
        echo 'Hello from ' . get_called_class() . ' ';
    }
}
 
Route::get('/', function (Service $service) {
    $service->sayHello();
    // die($service::class);
    return response('Hello World', 200)
                  ->header('Content-Type', 'text/plain');
});

 
Route::get('/request', function (Transistor $transistor, Request $request) {

    $transistor->parse('https://example.com');

    return response('ok', 200);
});