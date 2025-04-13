<?php

    use app\core\Application;

    /*
    |--------------------------------------------------------------------------
    | load
    |--------------------------------------------------------------------------
    |
    | This is were external packages are loaded.  It was intended to be a clean
    | way to reference packages that will be used in this project.
    |
    | There are some packages that are loaded by default. Other packages that
    | is not on the default list may be added in accordance with that
    | package instantiation or referencing rule
    |
    | -- Default Package List
    | @dotenv
    |
    | -- Additional Packages List
    |
    */
    $dotenv = Dotenv\Dotenv::createImmutable( dirname( __DIR__ ) );
    $config = $dotenv->load();

   /*
    |--------------------------------------------------------------------------
    | Tribe Framework Functions
    |--------------------------------------------------------------------------
    |
    | Functions is a list of functions within the application that provide a
    | quick and easy way to handle native PHP requests
    |
    | -- examples --
    |
    | redirect
    | : usage of redirect - redirect( $url )
    | ** this user to a different page internally and/or externally
    |
    | render
    | : usage or render - render( $page )
    | ** used to display a basic HTML/PHP page
    |
    */
    require_once dirname(__DIR__) . '/helpers/Functions.php';

    /*
     |------------------------------------------------------------------------
     | Instantiate Application object
     |------------------------------------------------------------------------
     */
    $app = new Application( $config );