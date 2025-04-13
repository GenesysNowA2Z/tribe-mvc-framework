<?php

namespace app\core\exception;

class NotFoundException extends \Exception {
    protected $code = 404;
    protected $message = 'This page could not be found.';
}