<?php
error_reporting(E_ALL |E_STRICT);
ini_set("display_errors", 1);

//Use SPL auto load SPL register instead of composer
spl_autoload_register(function ($class) {
    include ( realpath(dirname(__FILE__)) . '/src/'.$class.'.php' );
});
//call to main class to execute jobs
JobCaller::executeJobs(5);
