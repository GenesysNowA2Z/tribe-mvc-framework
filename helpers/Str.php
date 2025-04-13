<?php

    /** -----------------------------------------------------------------------
     *  Genesys Project | String Helper Library
     *
     *  The String Helper Library provides a list of commonly used native
     *  PHP functions that format strings.
     * -----------------------------------------------------------------------
     *
     * @name        String Helper Library | Str
     *
     * @author      Vincent J. Rahming <vincent@genesysnow.com>
     *
     * @package     app/helpers
     *
     */

    namespace app\helpers;
    use app\core\Helper;

    class Str extends Helper {

        public function __construct() {

            parent::__construct();

        }

        /*
         * to do
         *
         * - string contains
         * - string begins with
         * - string ends with
         * - mask
         * - maskcc
         * - maskphone
         * - maskexp
         * - maskcvv
         * - extract
         * - inject
         * - swap
         * - squeeze
         * - title
         */

       /*
       |--------------------------------------------------------------------------
       | allcaps
       |--------------------------------------------------------------------------
       |
       | returns the string argument in all capital letters
       |
       | @var string $argument
       |
       | @example Str::allcaps( 'HelloWorld' )
       |
       | @result: HELLOWORLD
       |
       */
        public static function allcaps( string $argument ) : string {
            return Str::allcaps( $argument );
        }

       /*
       |--------------------------------------------------------------------------
       | camelcase
       |--------------------------------------------------------------------------
       |
       | returns the string argument in camelcase
       |
       | @var string $argument
       |
       | @example Str::camelcase( 'HelloWorld' )
       |
       | @result: helloWorld
       |
       */
        public static function camelcase( string $argument ) : string {

            $string = null;
            $count = 0;

            foreach( explode( ' ', $argument ) as $word ) :
                if ( $count == 0 ) :
                    $string .= Str::nocaps( $word );
                else:
                    $string .= ucwords( $word );
                endif;
                ++$count;
            endforeach;

            return $string;

        }

        /*
        |--------------------------------------------------------------------------
        | count
        |--------------------------------------------------------------------------
        |
        | returns the count of characters in the string argument provided
        |
        | @var string $argument
        |
        | @example Str::count( 'HelloWorld' )
        |
        | @result: 10 ( int )
        |
        */
        public static function count( string $argument ) : int {
            return strlen( $argument  );
        }

        /*
        |--------------------------------------------------------------------------
        | empty
        |--------------------------------------------------------------------------
        |
        | returns the test result of the empty check on the string provided.
        |
        | @var string $argument
        |
        | @example Str::empty( 'HelloWorld' )
        |
        | @result: false
        |
        */
        public static function empty( $argument  ) : bool {

            if ( is_null( $argument ) OR
                 ( empty( $argument ) ) ) :
                return true;
            endif;

            return false;

        }

        /*
        |--------------------------------------------------------------------------
        | howmanytimes
        |--------------------------------------------------------------------------
        |
        | returns the integer value of the count of times the needle is found in
        | the haystack
        |
        | @var string $needle
        |
        | @var string $haystack
        |
        | @example Str::howmanytimes( 'e', 'HelloWorld' )
        |
        | @result: 1 ( int )
        |
        */
        public static function howmanytimes( string $needle,
                                             string $haystack ) : int {

            return substr_count( $haystack, $needle );

        }

        /*
        |--------------------------------------------------------------------------
        | howmanywords
        |--------------------------------------------------------------------------
        |
        | returns the integer value of the count of words in a string
        |
        | @var string $needle
        |
        | @var string $haystack
        |
        | @example Str::howmanywords( 'Hello Word' )
        |
        | @result: 2 ( int )
        |
        */
        public static function howmanywords( string $argument ) : int {
            return str_word_count( $argument );
        }

        /*
        |--------------------------------------------------------------------------
        | is
        |--------------------------------------------------------------------------
        |
        | returns the test result of whether an argument is a string
        |
        | @var string $argument
        |
        | @example Str::is( 'Hello Word' )
        |
        | @result: true ( boolean )
        |
        */
        public static function is( $argument ) : bool {
            return is_string( $argument );
        }

        /*
        |--------------------------------------------------------------------------
        | lefttrim
        |--------------------------------------------------------------------------
        |
        | returns the string with the specified needle trimmed from the left side of
        | the haystack
        |
        | @var string $needle
        |
        | @var string $haystack
        |
        | @example Str::lefttrim( 'H', 'Hello Word' )
        |
        | @result: 'ello World';
        |
        */
        public static function lefttrim( string $needle, string $haystack ) : string {
            return ltrim( $haystack, $needle );
        }

        /*
        |--------------------------------------------------------------------------
        | limit
        |--------------------------------------------------------------------------
        |
        | returns the partial value of the string from the starting point and up to
        | the specified limit.
        |
        | @var string $argument
        |
        | @var string $start
        |
        | @var string $limit
        |
        | @example Str::limit( 'Hello Word', 1, 4 )
        |
        | @result: 'ello';
        |
        */
        public static function limit( string $argument,
                                      int $start,
                                      int $limit ) : string {

            return substr( $argument, $start, $limit );
        }

        /*
        |--------------------------------------------------------------------------
        | maskcc
        |--------------------------------------------------------------------------
        |
        | returns the masked credit card number ( last for digits ) in x-1111
        | format
        |
        | @var string $cardnumber
        |
        | @example Str::maskcc( '4111-1111-1111-1112' )
        |
        | @result: 'x-1112';
        |
        */

        public static function maskcc( string $cardnumber ) : ?string {

            if ( self::count( self::replace( [ '-', ' '],
                    '', $cardnumber ) ) == 16 ) :

                return 'x-' . self::limit( self::replace( [ '-', ' '],
                        '', $cardnumber ), 12, 4 );
            endif;
            return null;

        }

        /*
        |--------------------------------------------------------------------------
        | match
        |--------------------------------------------------------------------------
        |
        | returns a boolean value with the two arguments provided do not match. if
        | a strength value is passed, then the === check is applied.
        |
        | @var string $argumentOne
        |
        | @var string $argumentTwo
        |
        | @var string $strength ( null = weak, weak, strong )
        |
        | @example Str::match( 'Rainbow Siege', 'Rainbow Siege', strong )
        |
        | @result: true ( boolean );
        |
        */

        public static function match( string $argumentOne,
                                      string $argumentTwo,
                                      $strength = false
                                     ) : bool {

            if ( empty( $strength ) OR
                 ( $strength == 'weak' ) ) :

                if ( $argumentOne == $argumentTwo ) :

                    return true;

                else:

                    return false;

                endif;

            elseif ( $strength == 'strong' ) :

                if ( $argumentOne === $argumentTwo ) :

                    return true;

                else:

                    return false;

                endif;

            endif;

        }

        /*
        |--------------------------------------------------------------------------
        | nocaps
        |--------------------------------------------------------------------------
        |
        | returns the string without any capital letters
        |
        | @var string $argument
        |
        | @example Str::nocaps( 'Hello World' )
        |
        | @result: 'hello world';
        |
        */
        public static function nocaps( string $argument ) : string {
            return strtolower( $argument );
        }

        /**
         * @name    otp
         *
         * @param int $type     Determine if the result is numeric, alphabetic
         *                      or alphanumeric.
         *                      1 - alphabetic, 2 - numeric, 3 - alphanumeric
         *                      $type defaults to 1 f not specified
         *
         * @param int $length   Determines the length of the two-factor auth
         *                      string.
         *                      The options include 4,6,7 or 8
         *                      $length defaults to 6 if not specified
         *
         * @param int $case     Determines the case in which the two-factor
         *                      auth string is returned
         *                      L = lower, U = upper, M = mixed
         *                      $case defaults to l if not specified
         *
         */
        public static function otp( $type = false,
                                    $length = false,
                                    $case = false ) : ?string {


            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | pascalcse
        |--------------------------------------------------------------------------
        |
        | returns the string in pascal case format
        |
        | @var string $argument
        |
        | @example Str::pascalcase( 'Hello World is my variable' )
        |
        | @result: 'HelloWorldIsMyVariable';
        |
        */

        public static function pascalcase( string $argument ) : string {

            $string = null;

            foreach( explode( ' ', $argument ) as $word ) :

                $string .= ucwords( $word );

            endforeach;

            return $string;

        }

       /*
       |--------------------------------------------------------------------------
       | random
       |--------------------------------------------------------------------------
       |
       | returns a random string of text with the specified length
       |
       | @var string $argument
       |
       | @example Str::random( 6 )
       |
       | @result: '819ds1';
       |
       */

        public static function random( int $argument ) : string {

            return self::limit( bin2hex( random_bytes( $argument ) ),
                0, $argument );

        }

       /*
       |--------------------------------------------------------------------------
       | remove
       |--------------------------------------------------------------------------
       |
       | returns a random string of text with the specified length
       |
       | @var string $argument
       |
       | @example Str::random( 6 )
       |
       | @result: '819ds1';
       |
       */

        public static function remove( string $needle,
                                       string $haystack ) : string {

            return str_replace( $needle, '', $haystack );

        }

       /*
       |--------------------------------------------------------------------------
       | replace
       |--------------------------------------------------------------------------
       |
       | returns a string where the needle ( search value ) has been replaced
       | with the replacement ( $replacement value ) in the haystack
       |
       | @var string $needle
       |
       | @var string $replacement
       |
       | @var string $haystack
       |
       | @example Str::replace( 'car','truck', 'John drove his car to work' );
       |
       | @result: 'John drove his truck to work';
       |
       */

        public static function replace( $needle,
                                        string $replacement,
                                        string $haystack ) : ?string {

            if ( Str::is( $needle ) == true ) :

                return str_replace( $needle, $replacement, $haystack );

            elseif ( is_array( $needle ) ) :

                foreach( $needle as $splint ) :

                    $haystack = str_replace( $splint, $replacement, $haystack );

                endforeach;

                return $haystack;

            endif;

            return null;

        }

        /*
        |--------------------------------------------------------------------------
        | righttrim
        |--------------------------------------------------------------------------
        |
        | returns the string with the specified needle trimmed from the right side
        | of the haystack
        |
        | @var string $needle
        |
        | @var string $haystack
        |
        | @example Str::righttrim( 'rld', 'Hello World' )
        |
        | @result: 'Hello Wo';
        |
        */

        public static function righttrim( string $needle, string $haystack ) : string {

            return rtrim( $haystack, $needle );

        }

        /*
        |--------------------------------------------------------------------------
        | slug
        |--------------------------------------------------------------------------
        |
        | returns a string formatted as a slug
        |
        | @var string $argument
        |
        | @example Str::slug( 'A blog about this guy name Vincent )
        |
        | @result: 'a-blog-about-this-guy-name-vincent';
        |
        */

        public static function slug( string $argument ) : string {

            return self::replace( ' ',
                '-', self::nocaps( $argument ) );

        }

        /*
        |--------------------------------------------------------------------------
        | snakecase
        |--------------------------------------------------------------------------
        |
        | returns a string in snake case format
        |
        | @var string $argument
        |
        | @example Str::snakecase( 'Make Me A Variable'  );
        |
        | @result: 'make_me_a_variable';
        |
        */
        public static function snakecase( string $argument ) : string {

            return Str::nocaps( Str::replace( ' ', '_', $argument ) );

        }

        /*
        |--------------------------------------------------------------------------
        | stitch
        |--------------------------------------------------------------------------
        |
        | returns a string of text with a concatenated value of all the values of
        | the array argument
        |
        | @var string $argument
        |
        | @example Str::stitch( 'Tie','Who' => 'Me','Together' );
        |
        | @result: 'TieMeTogether';
        |
        */

        public static function stitch( array $arguments ) : ?string {

            if ( !is_array( $arguments ) ) :
                return null;
            endif;

            return implode( '', $arguments );

        }

        /*
        |--------------------------------------------------------------------------
        | title
        |--------------------------------------------------------------------------
        |
        | returns a string of uppercase words
        |
        | @var string $argument
        |
        | @example Str::title( ' All the world is a stage ' );
        |
        | @result: 'All The World Is A Stage';
        |
        */
        public static function title( string $argument ) : string {
            return ucwords( $argument );
        }

        /*
        |--------------------------------------------------------------------------
        | trim
        |--------------------------------------------------------------------------
        |
        | returns a string with all the whitespace removed from both sides
        |
        | @var string $argument
        |
        | @example Str::trim( ' Remove the space ' );
        |
        | @result: 'Remove the space';
        |
        */
        public static function trim( string $argument ) : string {
            return trim( $argument );
        }

        /**
         * @name    twofactorauth
         *
         * @param int $type     Determine if the result is numeric, alphabetic
         *                      or alphanumeric.
         *                      1 - alphabetic, 2 - numeric, 3 - alphanumeric
         *                      $type defaults to 1 f not specified
         *
         * @param int $length   Determines the length of the two-factor auth
         *                      string.
         *                      The options include 4,6,7 or 8
         *                      $length defaults to 6 if not specified
         *
         * @param int $case     Determines the case in which the two-factor
         *                      auth string is returned
         *                      L = lower, U = upper, M = mixed
         *                      $case defaults to l if not specified
         *
         */

        /*
        |--------------------------------------------------------------------------
        | twofactorauth
        |--------------------------------------------------------------------------
        |
        | returns a random string of text with the specified length
        |
        | @var string $argument
        |
        | @example Str::random( 6 )
        |
        | @result: '819ds1';
        |
        */

        public static function twofactorauth( $type = false,
                                              $length = false,
                                              $case = false ) : ?string {

            $alphabet = 'abcdefghijklmnopqrstuvwxyz';
            $numbers  = '0123456789';

            if ( empty( $type ) ) :
                $type = '1';
            else:
                if ( !is_numeric( $type ) ) :
                    $type = '1';
                else:
                    $type = '1';
                endif;
            endif;

            return null;

        }

        /*
        |--------------------------------------------------------------------------
        | uuid
        |--------------------------------------------------------------------------
        |
        | returns a random string of text with the specified length
        |
        | @var string $argument
        |
        | @example Str::random( 6 )
        |
        | @result: '819ds1';
        |
        */
        public static function uuid( $case = false ) {

            if ( empty( $case ) OR
                !is_string( $case ) OR
                $case != 'U' )  :

                $case = 'L';

            endif;

            if ( function_exists( 'com_create_guid' ) ) :
                return com_create_guid();
            else :
                mt_srand( (double) microtime() * 10000 );
                $charid = md5( uniqid(rand(), true ) );
                $hyphen = chr(45 ); // "-"
                $uuid   = substr( $charid, 0, 8 )  . $hyphen
                    .substr( $charid, 8, 4 )  . $hyphen
                    .substr( $charid, 12, 4 ) . $hyphen
                    .substr( $charid, 16, 4 ) . $hyphen
                    .substr( $charid, 20,12 );

                if ( $case == 'L' ) :
                    return strtolower( $uuid );
                else:
                    return strtoupper( $uuid );
                endif;

            endif;

        }

        /** -----------------------------------------------------------------------
         *  Chained Methods
         *
         *  The String Helper Library provides a list of commonly used native
         *  PHP functions that format strings.
         * -----------------------------------------------------------------------
         */

        public static function of( string $argument ) {

            static::$argument = $argument;
            return new static;

        }

        public static function beforeposition( int $position ) {

            self::$argument = substr( self::$argument, 0, $position );
            return static::result( __FUNCTION__ );

        }

        public static function afterposition(  $position ) : string {
            self::$argument = substr( self::$argument, $position );
            return static::result( __FUNCTION__ );
        }

        public static function append( string $argument ) {

            self::$argument = self::stitch([ self::$argument, $argument ]);
            return static::result( __FUNCTION__ );

        }

        public static function prepend( string $argument ) {

            self::$argument = self::stitch( [ $argument, self::$argument ] );
            return static::result( __FUNCTION__ );

        }

        public static function explode( $format ) : array {

            static::$argument = explode( "$format", self::$argument );
            return static::result( __FUNCTION__ );

        }

        public static function hash( $type ) {

            $acceptedTypes =
                [
                    'md5',
                    'password_hash',
                    'sha1'
                ];

            if ( !in_array( $type, $acceptedTypes ) ) :

                static::$argument = null;

            else:

                if ( $type == 'md5' ) :

                    static::$argument = md5( static::$argument );

                elseif ( $type == 'password_hash' ) :

                    static::$argument = password_hash( static::$argument, PASSWORD_BCRYPT );

                elseif ( $type == 'sha1' ) :

                    static::$argument = sha1( static::$argument );

                endif;

            endif;

            return static::result( __FUNCTION__ );

        }

        public static function randomstring( $length = 10 ) {

            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen( $characters );
            $randomString = '';

            for ( $i = 0; $i < $length; $i++ ) :
                $randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
            endfor;

            return $randomString;

        }

        public static function createotp( $length = 6 ) {

            $characters = '0123456789';
            $charactersLength = strlen( $characters );
            $randomString = '';

            for ( $i = 0; $i < $length; $i++ ) {
                $randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
            }

            return $randomString;

        }

    }
