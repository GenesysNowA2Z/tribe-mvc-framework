<?php

    namespace app\core;
    use app\core\Request;

    class Security {

       /*
        |--------------------------------------------------------------------------
        | csrf
        |--------------------------------------------------------------------------
        |
        | creates a unique csrf token and adds it to a session.  this same key is
        | automatically added to a form when the open method is invoked.
        |
        | @example Security::csrf();
        |
        */
        public static function csrf() {
            if ( ! session('csrf') )
                addsession( 'csrf', bin2hex( random_bytes(35 ) ) );
        }

       /*
        |--------------------------------------------------------------------------
        | validateCSRF
        |--------------------------------------------------------------------------
        |
        | checks the existing method of the page to determine if it is a post. On
        | POST, the method evaluates the session value against the value that is
        | stored in the form to ensure that they match. if they don't then the
        | forbidden status is displayed.
        |
        | @example Security::validateCSRF
        |
        */
        public static function validateCSRF() {
            if ( Application::$app->request->isPost() ) :
                if ( isset( $_POST['csrf'] ) ) :
                    if ( $_POST['csrf'] !== session('csrf') ) :
                        setHttpStatusCode(403);
                        exit('This operation is not permitted');
                    endif;
                endif;
            endif;
        }

       /*
        |--------------------------------------------------------------------------
        | incrementFailedLoginAttempts
        |--------------------------------------------------------------------------
        |
        | checks the existing method of the page to determine if it is a post. On
        | POST, the method evaluates the session value against the value that is
        | stored in the form to ensure that they match. if they don't then the
        | forbidden status is displayed.
        |
        | @example Security::validateCSRF
        |
        */
        public static function incrementFailedLoginAttempts() {

        }

       /*
        |--------------------------------------------------------------------------
        | resetFailedLoginAttempts
        |--------------------------------------------------------------------------
        |
        | checks the existing method of the page to determine if it is a post. On
        | POST, the method evaluates the session value against the value that is
        | stored in the form to ensure that they match. if they don't then the
        | forbidden status is displayed.
        |
        | @example Security::validateCSRF
        |
        */
        public static function resetFailedLoginAttempts() {

        }

    }