<?php

namespace app\core\middleware;
use app\core\exception\ForbiddenException;
use app\core\View;
use app\core\Session;
use app\core\Route;


class AuthMiddleware extends Middleware {
    public function __contruct($view) {
        $this->view = $view;
    }
    public function execute() {
        if (!Session::exists('UserAuthenticated')) :
            setHttpStatusCode('403');
//            views('_error');
//            error(
//                message: 'Authentication is required to access this page',
//                httpstatus: 403
//            );
        endif;
    }
}