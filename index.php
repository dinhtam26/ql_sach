<?php

require_once "define.php";

spl_autoload_register(function ($class) {
    include LIBS_PATH . $class . '.php';
});
Session::init();
$bootstrap = new Bootstrap();
