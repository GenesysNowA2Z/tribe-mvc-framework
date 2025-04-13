<?php

namespace app\core;
use app\helpers\Str;
use app\helpers\Security;

    class Helper {

        public static $argument;
        public static $chain = false;

        public function __construct() {}

        public static function result( $proxy ) {
            if ( static::$chain === false ) :
                static::getchains();
            endif;

            if ( static::$chain[0] === $proxy ) :
                array_shift( static::$chain );
            else:
                die( 'Can\t parse your chain' );
            endif;

            if ( count( static::$chain ) === 0 ) :
                $copy = static::$argument;
                static::$chain = false;
                static::$argument = '';
                return $copy;
            endif;
            return new static;
        }

        public static function getchains() {

            $temp = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS );
            for( $i = 0; $i < count( $temp ); ++$i ) :
                if ( $temp[$i]['function'] === 'result' ) :
                    $temp = $temp[ $i + 1 ];
                    break;
                endif;
            endfor;

            // Prepare variable
            $obtained = '';
            $current = 1;
            // Open that source and find the chain
            $handle = fopen( $temp['file'], "r" );
            if( !$handle ) return false;

            while( ( $text = fgets( $handle ) ) !== false ) :
                if ( $current >= $temp['line'] ) :
                    $obtained .= $text;
                    // Find break
                    if( strrpos( $text, ';' ) !== false )
                        break;
                endif;
                $current++;
            endwhile;

            fclose($handle);
            preg_match_all('/>(\w.*?)\(/', $obtained, $matches);
            static::$chain = $matches[1];
            return true;
        }

    }