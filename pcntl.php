<?php
`echo foo`;
die;
function p() {
    //在一个脚本中开启两个进程做两件事
    $pid = pcntl_fork();
    var_dump($pid);

    if($pid !==0 ) {
        echo 'I am a parent process'.PHP_EOL;
    } else {
        var_dump( getmypid() );
        echo 'I am a sub process' .PHP_EOL;
    }
}
function l() {
    echo str_repeat('=',32).PHP_EOL;
}
var_dump(shell_exec('echo foo'));

l();

var_dump(exec('echo bar'));

l();

var_dump(system('echo char'));

l();

$handle = popen('echo dua','r');

echo fread($handle,128);
pclose($handle);

l();
die;
$process = proc_open('php',[
   0 => ['pipe','r'],
   1 => ['pipe','w'],
   2 => ['pipe','w']
],$pipes);

if(is_resource($process)) {
    fwrite($pipes[0], '<?php echo "rua\\n"; ?>');
    fclose($pipes[0]);
    echo  stream_get_contents($pipes[1]);
    fclose($pipes[1]);
    proc_close($process);
}

l();

$process = new Swoole\Process(function (){
    echo 'Swoole'.PHP_EOL;
});

$process->start();
$process::wait();