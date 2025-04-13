<?php

    namespace app\helpers;
    use app\core\Helper;

    class Date extends Helper {

        private static string $operator;

       /*
        |--------------------------------------------------------------------------
        | date
        |--------------------------------------------------------------------------
        |
        | returns the current date in dd-mm-yy format
        |
        | @example Date::date()
        |
        | @result: 12-01-22;
        |
        */
        public static function date( $argument = false ): string {
            return ( empty( $argument ) ? date('d-M-Y \a\t h:i a') :
                date( 'd-M-Y \a\t h:i a', strtotime( $argument ) ) );
        }

       /*
        |--------------------------------------------------------------------------
        | getshortdate
        |--------------------------------------------------------------------------
        |
        | returns the current date in dd-mm-yy format
        |
        | @example Date::getshortdate()
        |
        | @result: 12-01-22;
        |
        */
        public static function getshortdate( $argument = false ): string {
            return ( empty( $argument ) ? date('d-m-y') :
                        date( 'd-m-y', strtotime( $argument ) ) );
        }

       /*
        |--------------------------------------------------------------------------
        | getlongdate
        |--------------------------------------------------------------------------
        |
        | returns the current date in dd-mm-yyyy format
        |
        | @example Date::getlongdate()
        |
        | @result: 12-01-2022;
        |
        */
        public static function getlongdate(): string{
            return ( empty( $argument ) ? date('F dS, Y') :
                        date( 'F dS, Y', strtotime( $argument ) ) );
        }

       /*
        |--------------------------------------------------------------------------
        | getfulldate
        |--------------------------------------------------------------------------
        |
        | returns the current date in full date format if no argument is provided
        |
        | If the argument is provided then return the full date according to provided date
        |
        | @var DateTime $argument
        |
        | @example Date::getfulldate()
        |
        | @result: Wednesday, January 12th, 2022;
        |
        */
        public static function getfulldate($argument = false): string{
            if ( ! empty( $argument) ) :
                return date('l, F jS, Y', strtotime( $argument ) );
            else:
                return date('l, F jS, Y');
            endif;
        }

       /*
        |--------------------------------------------------------------------------
        | getshortday
        |--------------------------------------------------------------------------
        |
        | returns the short day if no argument is provided
        |
        | If the argument is provided then return the short day according to provided date
        |
        | @var DateTime $argument
        |
        | @example Date::getshortday()
        |
        | @result: Wed;
        |
        */
        public static function getshortday( $argument = false ): string {
            if ( ! empty( $argument) ) :
                return date('D', strtotime($argument));
            else:
                return date('D');
            endif;
        }

       /*
        |--------------------------------------------------------------------------
        | getlongday
        |--------------------------------------------------------------------------
        |
        | returns the long day if no argument is provided
        |
        | If the argument is provided then return the long day according to provided date
        |
        | @var DateTime $argument
        |
        | @example Date::getlongday()
        |
        | @result: Wednesday;
        |
        */
        public static function getlongday( $argument = false ): string {
            if ( ! empty( $argument) ) :
                return date('l', strtotime( $argument ) );
            else:
                return date( 'l');
            endif;
        }

       /*
        |--------------------------------------------------------------------------
        | getnumericday
        |--------------------------------------------------------------------------
        |
        | returns the numeric value of day in the month
        |
        | If the argument is provided then return the numeric value of day according to provided date
        |
        | @var DateTime $argument
        |
        | @example Date::getnumericday()
        |
        | @result: 12;
        |
        */
        public static function getnumericday( $argument = false ): int{
            if ( ! empty( $argument) ) :
                return date('d', strtotime( $argument ) );
            else:
                return date('d');
            endif;
        }

       /*
        |--------------------------------------------------------------------------
        | getshortmonth
        |--------------------------------------------------------------------------
        |
        | returns the short month name if no argument is provided
        |
        | If the argument is provided then return the short month name according to provided date
        |
        | @var DateTime $argument
        |
        | @example Date::getshortmonth()
        |
        | @result: Jan;
        |
        */
        public static function getshortmonth( $argument = false ): string{
            if ( ! empty( $argument) ) :
                return date('M', strtotime( $argument ) );
            else:
                return date('M' );
            endif;
        }

       /*
        |--------------------------------------------------------------------------
        | getlongmonth
        |--------------------------------------------------------------------------
        |
        | returns the long month name if no argument is provided
        |
        | If the argument is provided then return the long month name according to provided date
        |
        | @var DateTime $argument
        |
        | @example Date::getlongmonth()
        |
        | @result: January;
        |
        */
        public static function getlongmonth( $argument = false ): string {
            if ( ! empty( $argument ) ) :
                return date('F', strtotime( $argument ) );
            else:
                return date("F");
            endif;
        }

       /*
        |--------------------------------------------------------------------------
        | getnumericmonth
        |--------------------------------------------------------------------------
        |
        | returns the numeric value of month in the year
        |
        | If the argument is provided then return the numeric value of month according to provided date
        |
        | @var DateTime $argument
        |
        | @example Date::getnumericmonth()
        |
        | @result: 01;
        |
        */
        public static function getnumericmonth( $argument = false ): int{
            if ( ! empty( $argument ) ) :
                return date('m', strtotime( $argument ) );
            else:
                return date('m' );
            endif;
        }

       /*
        |--------------------------------------------------------------------------
        | getshortyear
        |--------------------------------------------------------------------------
        |
        | returns the short year if no argument is provided
        |
        | If the argument is provided then return the short year according to provided date
        |
        | @var DateTime $argument
        |
        | @example Date::getshortyear()
        |
        | @result: 22;
        |
        */
        public static function getshortyear( $argument = false): int{
            if ( ! empty( $argument ) ) :
                return date('y', strtotime( $argument ) );
            else:
                return date('y' );
            endif;
        }

       /*
        |--------------------------------------------------------------------------
        | getlongyear
        |--------------------------------------------------------------------------
        |
        | returns the long year if no argument is provided
        |
        | If the argument is provided then return the long year according to provided date
        |
        | @var DateTime $argument
        |
        | @example Date::getlongyear()
        |
        | @result: 2022;
        |
        */
        public static function getlongyear( $argument = false ): int{
            if ( ! empty( $argument ) ) :
                return date('Y', strtotime( $argument ) );
            else:
                return date('Y' );
            endif;
        }

       /*
        |--------------------------------------------------------------------------
        | getshortdayofweek
        |--------------------------------------------------------------------------
        |
        | returns the short day name of the week day if no argument is provided
        |
        | If the argument is provided then return the short day name according to provided date
        |
        | @var DateTime $argument
        |
        | @example Date::getshortdayofweek()
        |
        | @result: Mon;
        |
        */
        public static function getshortdayofweek( $argument = false ): string {
            if ($argument) :
                return date("D", strtotime($argument));
            else:
                return date("D", strtotime("this week"));
            endif;
        }

       /*
        |--------------------------------------------------------------------------
        | getlongdayofweek
        |--------------------------------------------------------------------------
        |
        | returns the long day name of the week day if no argument is provided
        |
        | If the argument is provided then return the long day name according to provided date
        |
        | @var DateTime $argument
        |
        | @example Date::getlongdayofweek()
        |
        | @result: Monday;
        |
        */
        public static function getlongdayofweek( $argument = false ): string {
            if ($argument) :
                return date("l", strtotime($argument));
            else:
                return date("l", strtotime("this week"));
            endif;
        }

       /*
        |--------------------------------------------------------------------------
        | getnumericdayofweek
        |--------------------------------------------------------------------------
        |
        | returns the numeric value of week day
        |
        | If the argument is provided then return the numeric value of week day according to provided date
        |
        | @var DateTime $argument
        |
        | @example Date::getnumericdayofweek()
        |
        | @result: 22;
        |
        */
        public static function getnumericdayofweek( $argument = false ): int {
            if ($argument) :
                return date("w", strtotime($argument));
            else:
                return date("w");
            endif;
        }

       /*
        |--------------------------------------------------------------------------
        | getweekinyear
        |--------------------------------------------------------------------------
        |
        | returns the numeric value of week w.r.t year
        |
        | If the argument is provided then return the numeric value of week according to provided date
        |
        | @var DateTime $argument
        |
        | @example Date::getweekinyear()
        |
        | @result: 02;
        |
        */
        public static function getweekinyear( $argument = false ): int {
            if ($argument) :
                return date("W", strtotime($argument));
            else:
                return date("W");
            endif;
        }

       /*
        |--------------------------------------------------------------------------
        | getdayremainderweek
        |--------------------------------------------------------------------------
        |
        | returns the remainder days of week excluding current day
        |
        | If the argument is provided then return the remainder days of week according to provided date
        |
        | @var DateTime $argument
        |
        | @example Date::getdayremainderweek()
        |
        | @result: 03;
        |
        */
        public static function getdayremainderweek( $argument = false ): int {
            if ($argument) :
                return 7 - date("w", strtotime($argument));
            else:
                return 7 - date("w");
            endif;
        }

       /*
        |--------------------------------------------------------------------------
        | getdaysremainderyear
        |--------------------------------------------------------------------------
        |
        | returns the remainder days of the year excluding current day
        |
        | If the argument is provided then return the remainder days of the year according to provided date
        |
        | @var DateTime $argument
        |
        | @example Date::getdaysremainderyear()
        |
        | @result: 351;
        |
        */
        public static function getdaysremainderyear( $argument = false ): int {
            if ($argument) :
                $futuredate = strtotime($argument);
            else:
                $futuredate = strtotime("Last day of December");
            endif;
            $now = time();
            $timeleft = $futuredate - $now;
            return round((($timeleft / 24) / 60) / 60);
        }

       /*
        |--------------------------------------------------------------------------
        | getdayselapsedweek
        |--------------------------------------------------------------------------
        |
        | returns the passed day of the week excluding current day
        |
        | @var DateTime $argument
        |
        | @example Date::getdayselapsedweek()
        |
        | @result: 03;
        |
        */
        public static function getdayselapsedweek( $argument = false ): int {
            if ($argument) :
                return date("w", strtotime( $argument ) ) - 1;
            else:
                return date("w" ) - 1;
            endif;
        }

       /*
        |--------------------------------------------------------------------------
        | getdayselapsedyear
        |--------------------------------------------------------------------------
        |
        | returns the passed days of the year excluding current day
        |
        | @var DateTime $argument
        |
        | @example Date::getdayselapsedyear()
        |
        | @result: 12;
        |
        */
        public static function getdayselapsedyear(): int {
            $firstdayoftheyear = strtotime('First day of january this year');
            $now = time();
            $timeleft = $now - $firstdayoftheyear;
            $daysleft = round((($timeleft / 24) / 60) / 60);
            return $daysleft - 1;
        }

       /*
        |--------------------------------------------------------------------------
        | getage
        |--------------------------------------------------------------------------
        |
        | returns the age from the specified date in numeric value
        |
        | If the argument is provided then return the age in numeric value according to provided date
        |
        | @var DateTime $argument
        |
        | @example Date::getage('1995-08-09')
        |
        | @result: 34
        |
        */
        public static function getage( $argument ): int {
            $date = new \DateTime( $argument );
            return $date->diff( new \DateTime( date('Y-m-d', time() ) ) )->y;
        }

       /*
        |--------------------------------------------------------------------------
        | getelapsed
        |--------------------------------------------------------------------------
        |
        | returns the elapsed time based on specified unit
        |
        | If the argument is provided then return the age in numeric value according to provided date
        |
        | @var DateTime $argument
        |
        | @var STRING $unit
        |     - accepted values: year, month, day, hour, minute, second
        |
        | @example Date::getelapsed('1995-08-09','year')
        |
        | @result: 34
        |
        */
        public static function getelapsed($argument,$unit){
            $date = new \DateTime($argument);
            switch($unit):
                case 'year':
                    return $date->diff(new \DateTime(date('Y-m-d', time())))->y;
                case 'month':
                    return $date->diff(new \DateTime(date('Y-m-d', time())))->m;
                case 'day':
                    return $date->diff(new \DateTime(date('Y-m-d', time())))->d;
                case 'hour':
                    return $date->diff(new \DateTime(date('Y-m-d', time())))->h;
                case 'minute':
                    return $date->diff(new \DateTime(date('Y-m-d', time())))->i;
                case 'second':
                    return $date->diff(new \DateTime(date('Y-m-d', time())))->s;
            endswitch;
        }

       /*
        |--------------------------------------------------------------------------
        | subtract
        |--------------------------------------------------------------------------
        |
        | returns the static arguments that are used in the chain methods
        |
        | @var DateTime $date
        |
        | @example Date::subtract('01-01-2016')->years(12)
        |
        | @result: 01-01-2004;
        |
        */
        public static function subtract( $date = false ) {
            static::$argument = $date;
            static::$operator = '-';
            return new static;
        }

       /*
        |--------------------------------------------------------------------------
        | add
        |--------------------------------------------------------------------------
        |
        | returns the static arguments that are used in the chain methods
        |
        | @var DateTime $date
        |
        | @example Date::add('01-01-2016')->years(12)
        |
        | @result: 01-01-2028;
        |
        */
        public static function add( $date = false ) {
            static::$argument = $date;
            static::$operator = '+';
            return new static;
        }

       /*
        |--------------------------------------------------------------------------
        | years
        |--------------------------------------------------------------------------
        |
        | returns the date after adding or subtracting from the provided date in
        | the parent methods (add or subtract) of chain
        |
        | @var int $years
        |
        | @example Date::subtract('01-01-2016')->years(12)
        |
        | @result: 01-01-2004;
        |
        */
        public static function years( $years ): string {
            if (self::$argument) :
                $currentdate = date('d-m-Y', strtotime(self::$argument));
            else:
                $currentdate = date('d-m-Y', strtotime(time()));
            endif;
            return date("d-m-Y",
                strtotime(static::$operator . $years . " year", strtotime($currentdate)));
        }

       /*
        |--------------------------------------------------------------------------
        | months
        |--------------------------------------------------------------------------
        |
        | returns the date after adding or subtracting from the provided date in
        | the parent methods (add or subtract) of chain
        |
        | @var int $months
        |
        | @example Date::subtract('2016-01-01')->months(12)
        |
        | @result: 01-01-2015;
        |
        */
        public static function months( $months ): string {
            if (self::$argument) :
                $currentdate = date('d-m-Y', strtotime(self::$argument));
            else:
                $currentdate = date('d-m-Y', strtotime(time()));
            endif;
            return date("d-m-Y",
                strtotime(static::$operator . $months . " months", strtotime($currentdate)));
        }

       /*
        |--------------------------------------------------------------------------
        | days
        |--------------------------------------------------------------------------
        |
        | returns the date after adding or subtracting from the provided date in
        | the parent methods (add or subtract) of chain
        |
        | @var int $days
        |
        | @example Date::subtract('2016-01-01')->months(12)
        |
        | @result: 20-12-2015;
        |
        */
        public static function days( $days ): string {
            if (self::$argument) :
                $currentdate = date('d-m-Y', strtotime(self::$argument));
            else:
                $currentdate = date('d-m-Y', strtotime(time()));
            endif;
            return date("d-m-Y", strtotime(static::$operator . $days . " days", strtotime($currentdate)));

        }

       /*
        |--------------------------------------------------------------------------
        | hours
        |--------------------------------------------------------------------------
        |
        | returns the date after adding or subtracting from the provided date in
        | the parent methods (add or subtract) of chain
        |
        | @var int $hours
        |
        | @example Date::subtract('01-01-2016 06:20:35')->hours(12)
        |
        | @result: 31-12-2015 18:20:35;
        |
        */
        public static function hours( $hours ): string {
            if (self::$argument) :
                $currentdate = date("d-m-Y H:i:s", strtotime(self::$argument));
            else:
                $currentdate = date("d-m-Y H:i:s", strtotime(time()));
            endif;
            return date("d-m-Y H:i:s",
                strtotime(static::$operator . $hours . " hours", strtotime($currentdate)));
        }

       /*
        |--------------------------------------------------------------------------
        | minutes
        |--------------------------------------------------------------------------
        |
        | returns the date after adding or subtracting from the provided date in
        | the parent methods (add or subtract) of chain
        |
        | @var int $hours
        |
        | @example Date::subtract('01-01-2016 06:20:35')->minutes(12)
        |
        | @result: 01-01-2016 06:08:35;
        |
        */
        public static function minutes( $minutes ): string {
            if (self::$argument) :
                $currentdate = date("d-m-Y H:i:s", strtotime(self::$argument));
            else:
                $currentdate = date("d-m-Y H:i:s", strtotime(time()));
            endif;
            return date("d-m-Y H:i:s",
                strtotime(static::$operator . $minutes . " minutes", strtotime($currentdate)));
        }

       /*
        |--------------------------------------------------------------------------
        | seconds
        |--------------------------------------------------------------------------
        |
        | returns the date after adding or subtracting from the provided date in
        | the parent methods (add or subtract) of chain
        |
        | @var int $hours
        |
        | @example Date::subtract('01-01-2016 06:20:35')->seconds(12)
        |
        | @result: 01-01-2016 06:20:23;
        |
        */
        public static function seconds( $seconds ): string {
            if (self::$argument) :
                $currentdate = date("d-m-Y H:i:s", strtotime( self::$argument ) );
            else:
                $currentdate = date("d-m-Y H:i:s", strtotime(time()));
            endif;
            return date("d-m-Y H:i:s",
                strtotime(static::$operator . $seconds . " seconds", strtotime($currentdate)));
        }
    }