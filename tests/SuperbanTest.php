<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Zeevx\Superban\Middlewares\SuperbanMiddleware;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('throws no exception when request is  within limits set', function () {
    $middleware = new SuperbanMiddleware();
    $request = Request::create('/superban-test');
    for($i = 0; $i < 1; $i++){
        $middleware->handle($request, function ($req) {
            return new Illuminate\Http\Response('test response');
        }, 2, 2, 120);
    }
})->throwsNoExceptions();

it('throws correct exception when request is exceeds attempts and user is superban', function () {
    $middleware = new SuperbanMiddleware;
    $request = Request::create('/superban-test');
    for($i = 0; $i < 3; $i++){
        $middleware->handle($request, function ($req) {
            return new Illuminate\Http\Response('test response');
        }, 2, 2, 120);
    }
    Mail::assertSentCount(1);
})->throws(HttpException::class, 'Too Many Attempts.');
