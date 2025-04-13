<?php

    namespace app\helpers;
    use app\core\Helper;
    use Twilio\Rest\Client;

    class Sms Extends Helper {

        public static $message;
        public static function to( string $mobile ) {

            if ( self::validateMobile( $mobile ) ) :
                // Your Account SID and Auth Token from twilio.com/tribe
                $sid = $_ENV['TWILIO_SID'];
                $token = $_ENV['TWILIO_SID_AUTH_TOKEN'];
                $client = new Client($sid, $token);
                try {
                    // Use the client to do fun stuff like send text messages!
                    $client->messages->create(
                    // the number you'd like to send the message to
                        self::setformat( $mobile),
                        [
                            // A Twilio phone number you purchased at twilio.com/tribe
                            'from' => '+' . $_ENV['TWILIO_TEST_PHONE_NUMBER'],
                            // the body of the text message you'd like to send
                            'body' => self::$message
                        ]
                    );
                } catch (\Exception $e) {
                    dd($e);
                }
            else:
                die();
            endif;
        }

        /*
        |--------------------------------------------------------------------------
        | send
        |--------------------------------------------------------------------------
        |
        | returns the static argument
        |
        | @var string $argument
        |
        | The to function accepts one string argument to capture the phone number
        | to which the message will be sent
        |
        | @example Sms::send( 'This message' )->to('12421212111)
        |
        */
        public static function send( string $message ) {
            self::$message = $message;
            return new static;
        }

        private static function validateMobile( string $mobile ) : bool {
            if ( ! is_numeric( $mobile ) ) :
                return false;
            endif;
            return true;
        }

        private static function setformat( string $mobile ) {
            if ( Str::count( $mobile ) == 7 ) :
                return '+' . '1' . $_ENV['AREACODE'] . $mobile;
            elseif ( Str::count( $mobile ) == 10 ) :
                return '+' . '1' . $mobile;
            elseif ( Str::count( $mobile ) == 11 ) :
                return '+' . $mobile;
            endif;
        }
    }