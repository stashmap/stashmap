<?php

function redirect($uri = '') {
    $http_response_code = 302;
    header("Location: ".$uri, TRUE, $http_response_code);
    exit;
}


function geBaseSiteUrl(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'];
}
