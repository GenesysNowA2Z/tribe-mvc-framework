<?php

    namespace app\helpers;
    use app\core\Helper;
    use app\helpers\Arr;
    use app\helpers\Str;

    class Math extends Helper {

      /*
       |--------------------------------------------------------------------------
       | absolute
       |--------------------------------------------------------------------------
       |
       | returns a absolute value of a number
       |
       | @var float $argument
       |
       | @example Math::absolute( -4 )
       |
       | @result: 4;
       |
       */
        public static function absolute( float $argument ) : int|float {
            return abs($argument);
        }

      /*
       |--------------------------------------------------------------------------
       | add
       |--------------------------------------------------------------------------
       |
       | returns a sum of array
       |
       | @var array $arguments
       |
       | @example Math::add( [2,5,6] )
       |
       | @result: 13;
       |
       */
       public static function add( array $arguments ) :int|float {
           return array_sum($arguments);
       }

      /*
       |--------------------------------------------------------------------------
       | average
       |--------------------------------------------------------------------------
       |
       | returns a average of numeric values
       |
       | @var array $arguments
       |
       | @example Math::average( [25,5,35,50] )
       |
       | @result: 28.75;
       |
       */
       public static function average ( array $arguments ) : int|float {
            foreach ( $arguments as $key => $argument ) :
                if ( !is_numeric($argument)) :
                    unset($arguments[$key]);
                endif;
            endforeach;
            return Math::divide( [ Math::add($arguments), Arr::size($arguments) ] );
        }

       /*
        |--------------------------------------------------------------------------
        | ceil
        |--------------------------------------------------------------------------
        |
        | returns a ceil value of a number
        |
        | @var float $argument
        |
        | @example Math::ceil( 20.2 )
        |
        | @result: 21;
        |
        */
        public static function ceil( float $argument ) : int|float {
            return ceil($argument);
        }

      /*
       |--------------------------------------------------------------------------
       | cos
       |--------------------------------------------------------------------------
       |
       | returns a cosine of a radian angle
       |
       | @var float $argument
       |
       | @example Math::cos( 30.0 )
       |
       | @result: 0.15425144988758;
       |
       */
       public static function cos(float $argument ) : int|float {
            return cos($argument);
       }

      /*
       |--------------------------------------------------------------------------
       | divide
       |--------------------------------------------------------------------------
       |
       | returns a division of two number
       |
       | @var array $arguments
       |
       | @example Math::divide( [100,5] )
       |
       | @result: 20;
       |
       */
       public static function divide ( array $arguments ) : float|int {
            if ( Arr::size($arguments) == 2) :
                $arguments = Arr::values($arguments);
                return ( $arguments[0] / $arguments[1] );
            else:
                return 0;
            endif;
       }

      /*
       |--------------------------------------------------------------------------
       | exponent
       |--------------------------------------------------------------------------
       |
       | returns a subtraction of two number
       |
       | @var array $arguments
       |
       | @example Math::exponent( [10,3] )
       |
       | @result: 1000;
       |
       */
       public static function exponent ( array $arguments ) : float {
            if (Arr::size($arguments) == 2) :
                $arguments = Arr::values($arguments);
                return pow( $arguments[0], $arguments[1] );
            else:
                return 0;
            endif;
       }

      /*
       |--------------------------------------------------------------------------
       | floor
       |--------------------------------------------------------------------------
       |
       | returns a floor value of a number
       |
       | @var float $argument
       |
       | @example Math::floor( 20.2 )
       |
       | @result: 20;
       |
       */
       public static function floor( float $argument ) : float {
            return floor($argument);
       }

      /*
       |--------------------------------------------------------------------------
       | mode
       |--------------------------------------------------------------------------
       |
       | returns a mode of numeric values
       |
       | @var array $arguments
       |
       | @example Math::mode( [25,5,35,50,5] )
       |
       | @result: 5;
       |
       */
       public static function mode ( array $arguments ) : float|int {
           $values = array_count_values($arguments);
           return array_search(max($values), $values);
       }

      /*
       |--------------------------------------------------------------------------
       | multiply
       |--------------------------------------------------------------------------
       |
       | returns a multiplication of two number
       |
       | @var array $arguments
       |
       | @example Math::multiply( [100,5] )
       |
       | @result: 500;
       |
       */
       public static function multiply ( array $arguments ) : float {
            if (Arr::size($arguments) == 2) :
                $arguments = Arr::values($arguments);
                return ($arguments[0] * $arguments[1]);
            else:
                return 0;
            endif;
       }

      /*
       |--------------------------------------------------------------------------
       | sin
       |--------------------------------------------------------------------------
       |
       | returns a cosine of a radian sin
       |
       | @var float $argument
       |
       | @example Math::sin( 30.0 )
       |
       | @result: -0.98803162409286;
       |
       */
       public static function sin( float $argument ) : int|float {
            return sin($argument);
       }

      /*
       |--------------------------------------------------------------------------
       | sqrt
       |--------------------------------------------------------------------------
       |
       | returns a square root value of a number
       |
       | @var float $argument
       |
       | @example Math::sqrt( 100 )
       |
       | @result: 10;
       |
       */
       public static function sqrt( float $argument ) : float {
            return sqrt($argument);
       }

      /*
       |--------------------------------------------------------------------------
       | subtract
       |--------------------------------------------------------------------------
       |
       | returns a subtraction of two number
       |
       | @var array $arguments
       |
       | @example Math::subtract( [100,25] )
       |
       | @result: 75;
       |
       */
       public static function subtract( array $arguments ) : int|float {
            if (Arr::size($arguments) == 2) :
                $arguments = Arr::values($arguments);
                return ( $arguments[0] - $arguments[1] );
            else:
                return 0;
            endif;
       }

       public static function mean ( array $arguments ) {

       }

    }