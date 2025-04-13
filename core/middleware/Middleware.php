<?php

namespace app\core\middleware;
class Middleware{
    public static function registerMiddleware() {
        return [
            'auth' => AuthMiddleware::class
        ];
    }
}