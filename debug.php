<?php
function v() {
    $params = func_get_args();
    foreach ($params as $param) {
        echo "<pre>";
        var_dump($param);
        echo "</pre>";
    }
}

function vd() {
    $params = func_get_args();
    foreach ($params as $param) {
        echo "<pre>";
        var_dump($param);
        echo "</pre>";
    }    die;
}

function l($text) {
    $fp = fopen('log.txt', 'a');
    fwrite($fp, $text.PHP_EOL);  
    fclose($fp); 
}

function lt($text) {
    $now = new DateTime();
    $time = $now->format('d-m-Y H:i:s');
    $fp = fopen('log.txt', 'a');
    fwrite($fp, $time.' '.$text.PHP_EOL);  
    fclose($fp); 
}

function hr($text = '--------------------------') {
    echo "<pre>", $text, PHP_EOL, "</pre>";
}

function br() {
    echo "<br>";
}

function startTimeMeasure() {
    $GLOBALS['measureTime'] = hrtime(true);
}

function stopTimeMeasure() {
    // echo "<pre>", hrtime(true) - $GLOBALS['measureTime'], PHP_EOL, "</pre>";
    echo hrtime(true) - $GLOBALS['measureTime'], "</br>";
}