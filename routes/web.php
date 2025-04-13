<?php

    use app\controllers\IndexController;
    use \app\core\Route;

   /*
    |------------------------------------------------------------------------
    | Defined Routes
    |------------------------------------------------------------------------
    */

    Route::get( '/', [IndexController::class,'index'] );
