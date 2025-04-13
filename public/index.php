<?php

   /*
    |------------------------------------------------------------------------
    | Tribe Framework
    |------------------------------------------------------------------------
    |
    | @author:         Vincent J. Rahming <vincent@genesysnow.com>
    |
    | @description:    Tribe Framework is built in PHP for the purpose of
    |                  rapid developing proprietary web based software
    |                  solutions for the customers of the Tribe
    |                  Group of Companies
    |
    | @version:        1
    |
    |------------------------------------------------------------------------
    */
    require_once dirname( __DIR__ ) . '/vendor/autoload.php';
    require_once dirname( __DIR__ ) . '/boot/load.php';
    require_once dirname( __DIR__ ) . '/routes/web.php';

   /*
    |------------------------------------------------------------------------
    | Launch Application
    |------------------------------------------------------------------------
    */
    $app->launch();