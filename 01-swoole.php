<?php
//ps -ef 查看全部进程
//pstree 父进程
$server = new Swoole\Server('0.0.0.0',9502);
$server->set([
   'worker_num' => swoole_cpu_num()*2,
    'task_worker_num' => swoole_cpu_num()*3
]);
$server->on('start',function ($server){
   echo 'SWOOLE:服务启动'.PHP_EOL;
   echo  swoole_cpu_num().PHP_EOL;
});

$server->on('receive',function ($server,$fd,$from_id,$data){

});

$server->on('task',function ($server,$task){

});

$server->on('close',function ($server,$fd,$reactorId){

});
$server->start();