<?php
use Swoole\Coroutine;
use Swoole\Coroutine\System;
$wg= new Swoole\Coroutine\WaitGroup;

Coroutine::create(function () use ($wg){
   Coroutine::create(function () use ($wg){
       $wg->add();
       System::sleep(1);
       echo "1\n";
       $wg->done();
   });
    Coroutine::create(function () use ($wg){
        $wg->add();
        echo "2\n";
        $wg->done();
    });
    Coroutine::create(function () use ($wg){
        $wg->add();
        System::sleep(3);
        echo "3\n";
        $wg->done();
    });
    $wg->wait();
    echo "4\n";
});
