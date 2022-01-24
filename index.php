<?php
//Use SPL auto load SPL register instead of composer
spl_autoload_register(function ($class) {
    include ( realpath(dirname(__FILE__)) . '/src/'.$class.'.php' );
});
//call to main class to to execute jobs
JobCaller::executeJobs(5);
