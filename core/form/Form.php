<?php

    namespace app\core\form;
    use app\helpers\Arr;

    class Form {

        public static array $attributes = [];
        public static string $buttondisplay = '';
        public static string $preselectedValue = '';
        public static string $presetvalue = '';
        public static $required = null;
        public static array $selectBoxValues = [];

       /*
        |--------------------------------------------------------------------------
        | applyAttributes
        |--------------------------------------------------------------------------
        |
        | applies the attributes to a form or form input object and returns a
        | string of values.  This method is used for internal purposes only
        |
        */
        protected static function applyAttributes() : string {
            $attr = '';
            foreach( self::$attributes as $key => $value ) :
                $attr .= $key .' = "'. $value .'" ';
            endforeach;
            if ( self::$required === true ) :
                $attr .= ' required="true" ';
            endif;
            self::$attributes = [];
            return $attr;
        }

       /*
        |--------------------------------------------------------------------------
        | attribute
        |--------------------------------------------------------------------------
        |
        | Attribute provides the user with the ability to add an attribute key and
        | value pair to the form or to an input object including textarea, radio
        | buttons, checkboxes, input boxes and select boxes.
        |
        | @example Form::attribute( ['method' => 'POST' )
        |
        | @result < ... method="POST" ... >
        |
        */
        public static function attribute( array $attribute ) {
            self::$attributes[ Arr::keys($attribute)[0] ] = Arr::values($attribute)[0];
            return self::class;
        }

       /*
        |--------------------------------------------------------------------------
        | button
        |--------------------------------------------------------------------------
        |
        | Attribute provides the user with the ability to add an attribute key and
        | value pair to the form or to an input object including textarea, radio
        | buttons, checkboxes, input boxes and select boxes.
        |
        | @example Form::attribute( ['method' => 'POST' )
        |
        | @result < ... method="POST" ... >
        |
        */
        public static function button() {
            $button = '<button ';
            $button .= self::applyAttributes();
            $button .= '>'. PHP_EOL;
            $button .= ( empty( self::$buttondisplay ) ?
                'Button' : self::$buttondisplay
            );
            $button .='</button>';
            echo $button;
            return self::class;
        }

       /*
        |--------------------------------------------------------------------------
        | close
        |--------------------------------------------------------------------------
        |
        | this closes the form
        |
        | @example Form::close
        |
        | @result </form>
        |
        */
        public static function close() {
            echo '</form>';
            return self::class;
        }

       /*
        |--------------------------------------------------------------------------
        | input
        |--------------------------------------------------------------------------
        |
        | This represents multiple forms of inputs that use the input tag in html5.
        | To change the type, the user must simply specify the type attribute in
        | their entry. This method supports text, password, radio, checkbox, date
        | datetime, tel and number types as well as a host of additional HTML5
        | attributes.
        |
        | @example Form::attribute( ['name' => 'FirstName'] )
        |              ::attribute( ['placeholder' => 'First Name'] )
        |              ::attribute( ['type' => 'text'] )
        |              ::input();
        |
        | @result <input type="text" placeholder="First Name" name="FirstName" />
        |
        */
        public static function input() {
            $input = '<input ';
            $input .= self::applyAttributes();
            $input .= '/>'. PHP_EOL;
            echo $input;
            self::$required = null;
            return self::class;
        }

       /*
        |--------------------------------------------------------------------------
        | name
        |--------------------------------------------------------------------------
        |
        | This permits the selectbox to have a pre-determined value selected. This
        | is particularly handy in cases where a value has already been stored
        | and is may be displayed in the interface to be updated. The pre-
        | selected option will identify the item by adding the SELECTED
        | KEYWORD next to it
        |
        | @example Form::attribute( ['method' => 'POST' )
        |              ::preselected('name')
        |              ::selectbox()
        |
        | @result <option value="14" SELECTED>14</option>
        |
        */
        public static function buttondisplay( string $name ){
            self::$buttondisplay = $name;
            return self::class;
        }

       /*
        |--------------------------------------------------------------------------
        | open
        |--------------------------------------------------------------------------
        |
        | This represents the opening tags for a form. Generally the form requires
        | attributes that may or may not be present in every instance. With this
        | in mind, the user will declare all form attributes prior to the form
        | being declared to be open.
        |
        | @example Form::attribute( ['method' => 'POST' )::open()
        |
        | @result <form method="POST">
        |
        */
        public static function open(){
            $form = '<form ';
            $form .= self::applyAttributes();
            $form .= '>' . PHP_EOL;
            $form .= '<input type="hidden" name="csrf" value="';
            $form .= session('csrf');
            $form .= '" />' . PHP_EOL;
            echo $form;
            return self::class;
        }

       /*
        |--------------------------------------------------------------------------
        | preselected
        |--------------------------------------------------------------------------
        |
        | This permits the selectbox to have a pre-determined value selected. This
        | is particularly handy in cases where a value has already been stored
        | and is may be displayed in the interface to be updated. The pre-
        | selected option will identify the item by adding the SELECTED
        | KEYWORD next to it
        |
        | @example Form::attribute( ['method' => 'POST' )
        |              ::preselected('name')
        |              ::selectbox()
        |
        | @result <option value="14" SELECTED>14</option>
        |
        */
        public static function preselected( $argument ){
            self::$preselectedValue = $argument;
            return self::class;
        }

       /*
        |--------------------------------------------------------------------------
        | presetvalue
        |--------------------------------------------------------------------------
        |
        | This permits the selectbox to have a pre-determined value selected. This
        | is particularly handy in cases where a value has already been stored
        | and is may be displayed in the interface to be updated. The pre-
        | selected option will identify the item by adding the SELECTED
        | KEYWORD next to it
        |
        | @example Form::attribute( ['method' => 'POST' )
        |              ::preselected('name')
        |              ::selectbox()
        |
        | @result <option value="14" SELECTED>14</option>
        |
        */
        public static function presetvalue( $argument = false ){
            self::$presetvalue = $argument;
            return self::class;
        }

       /*
        |--------------------------------------------------------------------------
        | required
        |--------------------------------------------------------------------------
        |
        | This enforces the REQUIRED keyword ensuring that all fields that are
        | marked as such must contain a value before being submitted
        |
        | @example Form::attribute( ['name' => 'LastName' )
        |              ::attribute( ['type' => 'text' )
        |              ::required('name')
        |              ::input()
        |
        | @result <input type="text" name="LastName" REQUIRED />
        |
        */
        public static function required( ){
            self::$required = true;
            return self::class;
        }

        /*
         |--------------------------------------------------------------------------
         | selectbox
         |--------------------------------------------------------------------------
         |
         | This method defines a selectbox for a form. It must work in conjunction
         | with the listvalues() which defines the list of options to be added
         | to the selectbox as values
         |
         | @example Form::attribute( ['method' => 'POST' )::open()
         |
         | @result <form method="POST">
         |
         */
        public static function selectbox() {
            $select = '<select ';
            $select .= self::applyAttributes();
            $select .= '>'. PHP_EOL;
            if ( ! empty( self::$selectBoxValues ) ) :
                if ( Arr::isassoc( self::$selectBoxValues ) ) :
                    foreach( self::$selectBoxValues as $key => $value ) :
                        $select .= '<option value="'. $value .'"';
                        if ( !empty( self::$preselectedValue ) ) :
                            if ( self::$preselectedValue == $value ) :
                                $select .= ' SELECTED ';
                            endif;
                        endif;
                        $select .= '>'. $key .'</option>' . PHP_EOL;
                    endforeach;
                else:
                    foreach( self::$selectBoxValues as $argument ) :
                        $select .= '<option value="'. $argument .'"';
                        if ( !empty( self::$preselectedValue ) ) :
                            if ( self::$preselectedValue == $argument ) :
                                $select .= ' SELECTED ';
                            endif;
                        endif;
                        $select .= '>'. $argument .'</option>' . PHP_EOL;
                    endforeach;
                endif;
            endif;
            $select .= '</select>'. PHP_EOL;
            echo $select;
            self::$selectBoxValues = [];
            self::$preselectedValue = '';
            self::$required = null;
            return self::class;
        }

        /*
         |--------------------------------------------------------------------------
         | textarea
         |--------------------------------------------------------------------------
         |
         | This permits the selectbox to have a pre-determined value selected. This
         | is particularly handy in cases where a value has already been stored
         | and is may be displayed in the interface to be updated. The pre-
         | selected option will identify the item by adding the SELECTED
         | KEYWORD next to it
         |
         | @example Form::attribute( ['method' => 'POST' )
         |              ::preselected('name')
         |              ::selectbox()
         |
         | @result <option value="14" SELECTED>14</option>
         |
         */
        public static function textarea(){
            $textarea = '<textarea ';
            $textarea .= self::applyAttributes();
            $textarea .= '/>';
            if( self::$presetvalue != '' ) :
                $textarea .= self::$presetvalue;
            endif;
            $textarea .= '</textarea>' . PHP_EOL;
            echo $textarea;
            self::$presetvalue = '';
            self::$required = null;
            return self::class;
        }
    }