<?php

    namespace app\core;
    use app\helpers\Arr;
    use app\helpers\Str;



    class Session {

        protected const FLASH_KEY = 'flashMessages';

        public function __construct() {
            session_start([
                'name' => $_ENV['TRIBE_SESSION_NAME']
            ]);
            $flashMessages = $_SESSION[ self::FLASH_KEY ] ?? [];
            foreach( $flashMessages as $key => &$flashMessage  ) :
                $flashMessage['remove'] = true;
            endforeach;
            $_SESSION[ self::FLASH_KEY ] = $flashMessages;
        }

       /*
        |--------------------------------------------------------------------------
        | add
        |--------------------------------------------------------------------------
        |
        | adds a key pair value to the $_SESSION super global array
        |
        | @example Session::add( 'name', 'value');
        |
        */
        public static function add( string $key, $value ){
            $_SESSION[ Str::trim( $key ) ] = $value;
        }

       /*
        |--------------------------------------------------------------------------
        | count
        |--------------------------------------------------------------------------
        |
        | returns the number of key/value pairs in the $_SESSION super global array
        |
        | @example Session::count();
        |
        */
        public static function count(){
            return Arr::size( $_SESSION );
        }

       /*
        |--------------------------------------------------------------------------
        | drop
        |--------------------------------------------------------------------------
        |
        | removes/drops a key pair value to the $_SESSION super global array
        |
        | @example Session::drop('name');
        |
        */
        public static function drop( string $key ){
            unset( $_SESSION[ Str::trim($key) ] );
        }

       /*
        |--------------------------------------------------------------------------
        | get
        |--------------------------------------------------------------------------
        |
        | get a value the $_SESSION super global array using the index provided
        |
        | @example Session::get('name');
        |
        */
        public static function get( string $key ){
            return $_SESSION[ Str::trim($key) ] ?? null;
        }

       /*
        |--------------------------------------------------------------------------
        | exists
        |--------------------------------------------------------------------------
        |
        | determines whether an index is present in the $_SESSION super global
        | array
        |
        | @example Session::exists('name');
        |
        */
        public static function exists( string $key ){
            return ( in_array( $key, Arr::keys( $_SESSION ) ) ? true : false );
        }

       /*
        |--------------------------------------------------------------------------
        | logout
        |--------------------------------------------------------------------------
        |
        | destroys all items in the $_SESSION super global variable
        |
        | @example Session::logout( 'name', 'value');
        |
        */
        public static function logout(){
            foreach( $_SESSION as $key => $value ) :
                Session::drop($key);
            endforeach;
        }

        public static function addFlashMessage( string $key, $message ) {
            $_SESSION[self::FLASH_KEY][$key] = [
                'remove' => false,
                'value' => $message
            ];
        }

        public static function getFlashMessage( string $key ) {
            return $_SESSION[self::FLASH_KEY][$key]['value'] ?? null;
        }

//        public function setFlash( $key, $message ) {
//
//            $_SESSION[ self::FLASH_KEY ][$key] = [
//                'remove' => false,
//                'value' => $message
//            ];
//
//         }
//
//        public function getFlash( $key ) {
//            return $_SESSION[ self::FLASH_KEY ][ $key ][ 'value' ] ?? false;
//        }

        public function __destruct() {
            $flashMessages = $_SESSION[ self::FLASH_KEY ] ?? [];
            foreach( $flashMessages as $key => &$flashMessage  ) :
                if ( $flashMessage['remove'] ) :
                    unset( $flashMessages[$key] );
                endif;
            endforeach;
            $_SESSION[ self::FLASH_KEY ] = $flashMessages;
        }
    }