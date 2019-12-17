<?php
use Swoole\Coroutine;
use Swoole\Coroutine\Channel;
use Swoole\Coroutine\System;
Coroutine::create(function () {
    echo "1.\n";
    Coroutine::defer(function (){
        echo "2.\n";
    });
    echo "3\n";
    Coroutine::defer(function (){
        echo "4.\n";
    });
    throw new \Exception('something wrong');
    echo "5.\n";
});


die;
Coroutine::create(function () {
    $channel = new Channel;
    $cid = Coroutine::create(function ()use ($channel){
       echo "1.\n";
       $channel->push(Coroutine::getCid());
       Coroutine::yield();
        echo "3.\n";
    });
    Coroutine::create(function ()use($channel,$cid){
        echo "2.\n";
        System::sleep(3);
        echo $channel->pop()."\n";
        Coroutine::resume($cid);
        echo "3.\n";
    });
});