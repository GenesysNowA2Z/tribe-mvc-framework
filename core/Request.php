<?php

    namespace app\core;
    use app\core\Helper;
    use app\helpers;
    use app\helpers\Arr;
    use app\helpers\Str;

    class Request {

//        public static $allowed = [
//            'required',
//            'email',
//            'alpha',
//            'alphanumeric',
//            'max',
//            'min',
//            'nullable',
//            'unique'
//        ];

        /**
         * @var array[]
         */
        public static $allowed = [
            'required',
            'email',
            'alpha',
            'numeric',
            'alphanumeric',
            'max',
            'min',
            'nullable',
        ];

        public static function getURLPath() : string {
            $path = $_SERVER['REQUEST_URI'] ?? '/';
            if ( strlen( $path ) > 1 ) :
                $path = rtrim( $path, '/' );
            endif;
            $position = strpos( $path, '?' );
            if ( $position === false ) :
                return $path;
            else:
                return substr( $path, 0, $position );
            endif;
        }

        /**
         * @name    getMethod
         * @desc    Gets the super global method
         */
        public function method() {
            return strtolower( $_SERVER['REQUEST_METHOD'] );
        }

        public function vars() {
            print_r( requestParam() );
        }

        public function getBody() {

            $body = [];
            if ( $this->method() === 'get' ) :
                foreach( $_GET as $key => $value ) :
                    $body[ $key ] = filter_input(
                        INPUT_GET,
                        $key,
                        FILTER_SANITIZE_SPECIAL_CHARS
                    );
                endforeach;
            endif;

            if ( $this->method() === 'post' ) :
                foreach( $_POST as $key => $value ) :
                    $body[ $key ] = filter_input(
                        INPUT_POST,
                        $key,
                        FILTER_SANITIZE_SPECIAL_CHARS
                    );
                endforeach;
            endif;

            return $body;

        }

        public function isGet() {
            return $this->method() === 'get';
        }

        public function isPost( $name = false ) {
            if( empty( $name ) ) :
                return $this->method() === 'post';
            else:
                return isset( $_POST[$name] );
            endif;
        }

        /*
        |--------------------------------------------------------------------------
        | validate
        |--------------------------------------------------------------------------
        |
        | returns validation errors
        |
        | @var array $arguments
        |
        | @var array $rules
        |
        | The validate method accept two arguments, first array arguments of the request
        | parameters and the second array parameter rules that define to be validated.
        | If all the requested params are validated then empty array of errors will be
        | return otherwise, array of error messages will will be return.
        |
        | @example Validator::validate($request, [
                'firstname' => ['required','alpha'],
                'lastname' => ['required','alpha'],
                'email' => ['required','email'],
                'phone' => ['required','numeric'],
                'status' => ['required'],
            ]);
        |
        | @result: [];
        |
        */
        public static function validate( array $arguments, array $rules ) {
            $validation = $messages = [];
            foreach ( $arguments as $argKey => $argument ) :

                if(!isset($rules[$argKey])) continue;

                foreach ( $rules as $key => $rule ) :
                    foreach ( $rule as $item ) :

                        /* *
                         * Explode the rule:value
                         * */
                        $break = explode(':',$item);

                        if (!in_array($break[0], self::$allowed)) continue;

                        switch ($item) :
                            case 'required':
                                $validation[$key]['required'] = !empty($argument) ? true : false;
                                if($validation[$key]['required'] == false) $messages[$key]['required'] = ucwords("$key is required field");
                                break;
                            case 'email':
                                $validation[$key]['email'] = filter_var($argument, FILTER_VALIDATE_EMAIL) ? true : false;
                                if($validation[$key]['email'] == false) $messages[$key]['email'] = ucwords("$key is not valid");
                                break;
                            case 'alpha':
                                $validation[$key]['alpha'] = ctype_alpha($argument) ? true : false;
                                if($validation[$key]['alpha'] == false) $messages[$key]['alpha'] = ucwords("Only alphabets are allowed");
                                break;
                            case 'numeric':
                                $validation[$key]['numeric'] = is_numeric($argument) ? true : false;
                                if($validation[$key]['numeric'] == false) $messages[$key]['numeric'] = ucwords("Only numerics are allowed");
                                break;
                            case 'alphanumeric':
                                $validation[$key]['alphanumeric'] = preg_match("/^[ A-Za-z0-9]*$/", $argument) ? true : false;
                                if($validation[$key]['alphanumeric'] == false) $messages[$key]['alphanumeric'] = ucwords("Special characters are not allowed");
                                break;
                            case 'max':
                                $validation[$key]['max'] = isset($argument) && (strlen($argument) <= $break[1]) ? true : false;
                                if($validation[$key]['max'] == false) $messages[$key]['max'] = ucwords("Maximum ".$break[1]." characters are allowed");
                                break;
                            case 'min':
                                $validation[$key]['min'] = isset($argument) && (strlen($argument) >= $break[1]) ? true : false;
                                if($validation[$key]['min'] == false) $messages[$key]['min'] = ucwords("Minimum ".$break[1]." characters are allowed");
                                break;

                        endswitch;

                    endforeach;

                endforeach;

            endforeach;

            return $messages;

        }


//        public function validate( $arguments ) {
//
//            $messages = [];
//            foreach( $arguments as $key => $value ) :
//
//                if ( ! in_array( $key, Arr::keys( $_POST ) ) ) :
//                    $messages[$key][] = $value['label'] . ' field does not exists';
//                endif;
//                $rules = explode( '|', $value['rules'] );
//                foreach( $rules as $rule ) :
//                    $rule = explode(':', $rule );
//                    if ( ! in_array( $rule[0], self::$allowed ) ) :
//                        $messages[$key][] = $value['label'] . ' is using a rule ('. $rule[0] .') that is not permitted.';
//                    else:
//                        switch($rule[0]) :
//                            case 'required':
//                                ( ! in_array( $key, Arr::keys( $_POST ) ) ?
//                                    $messages[$key][] = $value['label'] . ' is a required field'
//                                    : null );
//                            break;
//                            case 'alpha':
//                                ( ! ctype_alpha( $_POST[$key] ) ?
//                                    $messages[$key][] = $value['label'] . ' must be alphabetic characters only'
//                                    : null );
//                            break;
//                            case 'alphanumeric':
//                                ( ! preg_match("/^[ A-Za-z0-9]*$/", $_POST[$key] ) ?
//                                    $messages[$key][] = $value['label'] . ' must contain alphanumeric characters'
//                                    : null );
//                            break;
//                            case 'email':
//                                ( ! filter_var( $_POST[$key], FILTER_VALIDATE_EMAIL ) ?
//                                    $messages[$key][] = $value['label'] . ' must be a valid email address'
//                                    : null );
//                                break;
//                            case 'numeric':
//                                ( ! is_numeric( $_POST[$key] ) ?
//                                    $messages[$key][] = $value['label'] . ' must be a numeric value '
//                                    : null );
//                                break;
//                            case 'min':
//                                ( ( Str::count( $_POST[$key] ) < $rule[1] ) ?
//                                    $messages[$key][] = $value['label'] . ' must be at least ' . $rule[1] . ' characters in length '
//                                    : null );
//                            break;
//                            case 'max':
//                                ( ( Str::count( $_POST[$key] ) > $rule[1] ) ?
//                                    $messages[$key][] = $value['label'] . ' must not exceed ' . $rule[1] . ' characters in length '
//                                    : null );
//                            break;
//                            case 'unique':
//
//                            break;
//                        endswitch;
//                    endif;
//                endforeach;
//            endforeach;
//
//            if ( !empty( $messages ) ) :
//                Session::addFlashMessage(
//                    'error',
//                    $value = $messages[ array_keys( $messages )[0] ][0]
//                );
//                return false;
////                redirect( $_SERVER['HTTP_REFERER'] );
//            endif;
//        }



    }