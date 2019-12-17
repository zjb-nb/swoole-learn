<?php
use Swoole\Coroutine;
use Swoole\Coroutine\Channel;
Swoole\Runtime::enableCoroutine();




Coroutine::create(function (){
   $channel = new Channel;
   Coroutine::create(function () use ($channel) {
      $addr_info = Coroutine::getaddrinfo('github.com');
      //JSON_PRETTY_PRINT 格式化输出
      $channel->push(['A',json_encode($addr_info),JSON_PRETTY_PRINT]);
   });
   Coroutine::create(function () use ($channel) {
      $mirror =Coroutine::readFile(__FILE__);
      $channel->push(['B',$mirror]);
      // echo $channel->length()."\n";
   });
   Coroutine::create(function () use ($channel) {
      $channel->push(['C',date(DATE_W3C)]);
       $channel->push(['C',date(DATE_W3C)]);
   });
  // echo $channel->length()."\n";
   for($i=4;$i--;){
       list($id,$data) = $channel->pop();
       echo  "From {$id}:\n{$data}\n";
       echo $channel->length()."\n";
   }
});