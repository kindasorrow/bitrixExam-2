<?php


if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/local/php_interface/include/events.php")) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/local/php_interface/include/events.php");
}

if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/local/php_interface/include/const.php")) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/local/php_interface/include/const.php");
}

if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/local/php_interface/include/agents.php")) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/local/php_interface/include/agents.php");
}