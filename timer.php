<?php

$timer = Swoole\Timer::tick(1*1000,function (){
   system('echo foo');
});
var_dump($timer);
Swoole\Timer::after(10*1000,function () use($timer){
   Swoole\Timer::clear($timer); 
});