<?php

    namespace app\helpers;
    class Validator{
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
    }