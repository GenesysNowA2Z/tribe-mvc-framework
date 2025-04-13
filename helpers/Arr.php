<?php

namespace app\helpers;
use app\core\Helper;

class Arr extends Helper {

    public static $types  =   [];

    public function __construct() {

        parent::__construct();
        static::$types  =   [
            'assoc',
            'seq'
        ];

//        self::$extractRules = [
//            'IF_EXISTS' => EXTR_OVERWRITE,
//            'OVERWRITE' => EXTR_OVERWRITE,
//            'SKIP' => EXTR_SKIP
//        ];

    }

   /*
    |--------------------------------------------------------------------------
    | addindex
    |--------------------------------------------------------------------------
    |
    | returns a boolean value.  True if the needle is found in the haystack and
    | false if the needle is not found in the haystack
    |
    | @var string $needle
    |
    | @var array $haystack
    |
    | @example Arr:contains( 'hello', [ 'goodbye', 'hello', 'welcome' ] )
    |
    | @result: true
    |
    */
    public static function addindex( string|array $needle, array $haystack ) {
        $haystack[] = $needle;
//        return $haystack;
    }

   /*
    |--------------------------------------------------------------------------
    | contains
    |--------------------------------------------------------------------------
    |
    | returns a boolean value.  True if the needle is found in the haystack and
    | false if the needle is not found in the haystack
    |
    | @var string $needle
    |
    | @var array $haystack
    |
    | @example Arr:contains( 'hello', [ 'goodbye', 'hello', 'welcome' ] )
    |
    | @result: true
    |
    */
    public static function contains( string $needle, array $haystack, $type ) : bool {
        if ($type == 'isassoc'):
            return in_array( $needle, array_keys($haystack));
        else:
            return in_array( $needle, $haystack );
        endif;
    }

    public static function compact( string $argument ) {
        return compact( $argument );
    }

    public static function extract( array $argument, string $rule  ) {
        if ( Arr::isassoc( $argument ) ) :
            return extract( $argument, $rule );
        endif;
    }

    # compact()
    public static function flatten() {

    }

    public static function get( $needle, array $haystack ) {

    }

   /*
    |--------------------------------------------------------------------------
    | is - Is Array
    |--------------------------------------------------------------------------
    |
    | returns a if the argument passed is of type array
    |
    | @var array $argument
    |
    | @example Arr::is( $argument  )
    |
    | @result: BOOLEAN true|false;
    |
    */
    public static function is( $argument ): bool {
        if ( is_array( $argument ) ) :
            return true;
        endif;
        return false;
    }

   /*
    |--------------------------------------------------------------------------
    | isassoc - Is Associative Array
    |--------------------------------------------------------------------------
    |
    | returns a boolean response if the array is an associative array.  If the
    | array is not associative ( true ), it is sequential ( false ).
    |
    | @var array $argument
    |
    | @example Arr::isassoc( $argument  )
    |
    | @result: false;
    |
    */
    public static function isassoc( array $argument ): bool {
        if ( self::keys($argument) !==
            range(0, count($argument) - 1 ) ) :
            return true;
        else:
            return false;
        endif;
    }

   /*
    |--------------------------------------------------------------------------
    | keys
    |--------------------------------------------------------------------------
    |
    | returns an array of only keys from the key/value pair. If the array is
    | not an associative array, a sequential array of values will be returned.
    | These values start at 0 and are incremented by 1 for each item present
    | in the array.
    |
    | @var array $argument
    |
    | @example Arr::keys( [ 'One' => 1, 'Two' => 2, 'Three' => 3 ] )
    |
    | @result: [ 'One', 'Two', 'Three' ];
    |
    */
    public static function keys( array $argument ) : array {
        return array_keys( $argument );
    }

   /*
    |--------------------------------------------------------------------------
    | push
    |--------------------------------------------------------------------------
    |
    | returns an array with a new index added to the end.
    |
    | @var string $needle
    |
    | @var array $haystack
    |
    | @example Arr::push( 'Four', [ 'One', 'Two', 'Three' ] )
    |
    | @result: [ 'One', 'Two', Three', 'Four' ];
    |
    */
    public static function push( $needle, array $haystack ): array {
        $haystack[] = $needle;
        return $haystack;
    }

    public static function range( int $min, int $max, $increment = false ) {
        if ( !empty( $increment ) AND
            ( is_int( $increment ) ) ) :
            return range( $min, $max, $increment );
        else:
            return range( $min, $max );
        endif;
    }

   /*
    |--------------------------------------------------------------------------
    | shuffle
    |--------------------------------------------------------------------------
    |
    | returns an array in random order.
    |
    | @var array $argument
    |
    | @example Arr::shuffle( [ 'One', 'Two', 'Three', 'Four'] )
    |
    | @result: [ 'Four', 'Two', 'One', 'Three' ];
    |
    */
    public static function shuffle( array $argument ) : array {
        shuffle( $argument );
        return $argument;
    }

    /*
     |--------------------------------------------------------------------------
     | size
     |--------------------------------------------------------------------------
     |
     | returns the size of an array
     |
     | @var array $argument
     |
     | @example Arr::size( [ 'One', 'Two', 'Three', 'Four'] )
     |
     | @result: 4;
     |
     */

    public static function size( array $argument) : int  {
        return count( $argument );
    }

    /*
     |--------------------------------------------------------------------------
     | values
     |--------------------------------------------------------------------------
     |
     | returns an array of only value from the key/value pair.
     |
     | @var array $argument
     |
     | @example Arr::keys( [ 'One' => 1, 'Two' => 2, 'Three' => 3 );)
     |
     | @result: [ 1, 2, 3 ];
     |
     */

    public static function values( array $argument ) : array {
        return array_values( $argument );
    }

    /** ************************************************************************
     *  Chainable Methods
     *
     *  The Array Helper Library provides a list of commonly used native
     *  PHP functions that manipulate arrays.
     *
     ** ********************************************************************** */


    /*
     |--------------------------------------------------------------------------
     | base
     |--------------------------------------------------------------------------
     |
     | returns a new static object. The base method collects and holds the
     | original argument. As other methods are chained, additional request
     | can may be applied.
     |
     | @var array $argument
     |
     | -- Chainable Methods for base
     | ->currentpos()
     | ->endpos()
     | ->nextpos()
     | ->prevpos()
     | ->reset()
     |
     | @example Arr::base( [ 'One', 'Two', 'Three' )->nextpos();
     |
     | @result: Two;
     |
     */

    public static function base( array $argument ) {
        self::$argument = $argument;
        return new self;
    }

   /*
    |--------------------------------------------------------------------------
    | currentpos
    |--------------------------------------------------------------------------
    |     | returns the value of the current index of an array.  This method is for
    | internal positioning ( pointing ) in an array
    |
    | @requires base()
    |
    | @var array $argument
    |
    | @example Arr::base( [ 1, 2, 3 ] )->current();
    |
    | @result: 1;
    |
    */
    public function currentpos() {
        self::$argument = current( self::$argument );
        return static::result( __FUNCTION__ );
    }

   /*
    |--------------------------------------------------------------------------
    | nextpos
    |--------------------------------------------------------------------------
    |
    | returns the value of the next index ( to the right of the current index )
    | of an array. This method is for internal positioning ( pointing ) within
    | the specified array
    |
    | @requires base()
    |
    | @var array $argument
    |
    | @example Arr::base( [ 1, 2, 3 ] )->nextpos();
    |
    | @result: 2;
    |
    */
    public function nextpos() {
        self::$argument = next(self::$argument );
        return self::result(__FUNCTION__);
    }

   /*
    |--------------------------------------------------------------------------
    | prevpos
    |--------------------------------------------------------------------------
    |
    | returns the value of the previous index ( to the left of the current
    | inedex ) of an array. This method is for internal positioning ( pointing )
    | within the specified array.
    |
    | @requires base()
    | @var array $argument
    |
    | @example Arr::base( [ 1, 2, 3 ] )->prevpos();
    |
    | @result: 2;
    |
    */
    public function prevpos() {
        self::$argument = previous( self::$argument );
        return self::result( __FUNCTION__ );
    }

   /*
    |--------------------------------------------------------------------------
    | resetpos
    |--------------------------------------------------------------------------
    |
    | returns the sends the internal pointer back to the starting position in
    | the array. This method is for internal positioning ( pointing )
    | within the specified array.
    |
    | @requires base()
    |
    | @var array $argument
    |
    | @example Arr::base( [ 1, 2, 3 ] )->reset();
    |
    | @result: 2;
    |
    */
    public function resetpos() {
        self::$argument = reset(self::$argument );
        return self::result(__FUNCTION__);
    }

   /*
    |--------------------------------------------------------------------------
    | drop
    |--------------------------------------------------------------------------
    |
    | returns a new static object. The drop method collects and holds the
    | original argument. As other methods are chained, additional request
    | can may be applied.
    |
    | @var array $argument
    |
    | -- Chainable Methods for drop
    | ->first()
    | ->last()
    | ->dupes()
    | ->position()
    |
    */
    public static function drop( array $argument ) {
        self::$argument = $argument;
        return new self;
    }

   /*
    |--------------------------------------------------------------------------
    | first
    |--------------------------------------------------------------------------
    |
    | returns the haystack with the first index removed
    |
    | @requires drop()
    | @var array $argument
    |
    | @example Arr::drop( [ 1, 2, 3 ] )->first();
    |
    | @result: [ 2, 3 ];
    |
    */
    public function first() {
        current( reset( self::$argument ) )[0];
        return self::result(__FUNCTION__ );
    }

   /*
    |--------------------------------------------------------------------------
    | last
    |--------------------------------------------------------------------------
    |
    | returns the haystack with the last index removed
    |
    | @requires drop()
    | @var array $argument
    |
    | @example Arr::drop( [ 1, 2, 3 ] )->last();
    |
    | @result: [ 1, 2 ];
    |
    */
    public function last() {
        array_pop( self::$argument );
        return self::result(__FUNCTION__ );
    }

   /*
    |--------------------------------------------------------------------------
    | duplicates
    |--------------------------------------------------------------------------
    |
    | returns the haystack with all duplicates removed
    |
    | @requires drop()
    |
    | @var array $argument
    |
    | @example Arr::drop( [ 1, 2, 3, 3, 4 ] )->duplicates();
    |
    | @result: [ 1, 2, 3, 4 ];
    |
    */
    public function duplicates() {
        array_unique( self::$argument );
        return self::result(__FUNCTION__ );
    }

   /*
    |--------------------------------------------------------------------------
    | position
    |--------------------------------------------------------------------------
    |
    | returns the haystack with the specified position removed.
    |
    | @requires drop()
    |
    | @var array $argument
    |
    | @example Arr::drop( [ 1, 2, 3 ] )->position( $type, $argument );
    |
    | @result: [ 1, 2 ];
    |
    */
    public function position( string $type, $key ) {
        if ( self::contains( $type, self::$types ) ) :
            unset( self::$argument[ $key ] );
            self::$argument = self::values( self::$argument );
            return self::result(__FUNCTION__ );
        else:
            return null;
        endif;
    }

   /*
    |--------------------------------------------------------------------------
    | sort
    |--------------------------------------------------------------------------
    |
    | returns a new static object. The sort method collects and holds the
    | original argument. As other methods are chained, additional request
    | can may be applied.
    |
    | @var array $argument
    |
    | -- Chainable Methods for drop
    | ->ascending()
    | ->descending()
    | ->natural()
    |
    */
    public static function sort( array $argument ) {
        self::$argument = $argument;
        return new self;
    }

   /*
    |--------------------------------------------------------------------------
    | ascending
    |--------------------------------------------------------------------------
    |
    | returns the array in ascending order
    |
    | @requires sort()
    |
    | @var array $argument
    |
    | @example Arr::sort( [ 1, 3, 2 ] )->ascending();
    |
    | @result: [ 1, 2, 3 ];
    |
    */
    public function ascending() {
        if ( self::isassoc( self::$argument ) ) :
            ksort( self::$argument );
            return self::result(__FUNCTION__ );
        else:
            sort( self::$argument );
            return self::result(__FUNCTION__ );
        endif;
    }

   /*
    |--------------------------------------------------------------------------
    | descending
    |--------------------------------------------------------------------------
    |
    | returns the array in descending order
    |
    | @requires sort()
    |
    | @var array $argument
    |
    | @example Arr::sort( [ 1, 3, 2 ] )->descending();
    |
    | @result: [ 3, 2, 1 ];
    |
    */
    public function descending() {
        if ( self::isassoc( self::$argument ) ) :
            krsort( self::$argument );
            return self::result( __FUNCTION__ );
        else:
            rsort( self::$argument );
            return self::result( __FUNCTION__ );
        endif;
    }

   /*
    |--------------------------------------------------------------------------
    | natural
    |--------------------------------------------------------------------------
    |
    | returns the array in natural order
    |
    | @requires sort()
    |
    | @var array $argument
    |
    | @example Arr::sort( [ 1, 3, 2 ] )->natural();
    |
    | @result: [ 3, 2, 1 ];
    |
    */
    public function natural() {
        natsort( self::$argument );
        return self::result( __FUNCTION__ );
    }

   /*
    |--------------------------------------------------------------------------
    | stitch
    |--------------------------------------------------------------------------
    |
    | returns a new static object. The sort method collects and holds the
    | original argument. As other methods are chained, additional request
    | can may be applied.
    |
    | @var array $argument
    |
    | -- Chainable Methods for drop
    | ->with()
    |
    */
    public static function stitch( array $argument ) {
        self::$argument = $argument;
        return new self;
    }

   /*
    |--------------------------------------------------------------------------
    | with
    |--------------------------------------------------------------------------
    |
    | returns a string from the values of a given array and concatenates the
    | values ine array with the given "thread"
    |
    | @requires stitch()
    |
    | @var array $argument
    |
    | @example Arr::stitch( [ 1, 3, 2 ] )->with( '***);
    |
    | @result: 1***3***1;
    |
    */

    public function with( string $thread ) {
        self::$argument = implode( $thread, self::$argument );
        return self::result( __FUNCTION__ );
    }

}