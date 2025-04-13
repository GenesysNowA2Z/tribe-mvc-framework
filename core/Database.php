<?php

    namespace app\core;
    use app\helpers\Str;

    class Database extends Controller {

        /*
         |--------------------------------------------------------------------------
         | connect method
         |--------------------------------------------------------------------------
         |
         | The connect method accepts connection parameters and attempts to create
         | an instance of PDO. If the instance is created successfully, then it
         | is used to execute other methods.  All exceptions are handled.
         |
         */
        public static function connect() {
            $dsn = $_ENV['DB_PLATFORM'] .':host='. $_ENV['DB_HOST']
                .';port='. $_ENV['DB_PORT']
                .';dbname='. $_ENV['DB_NAME']
                .';charset='. $_ENV['DB_CHARSET'];
            try {
                $pdo = new \PDO( $dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD'] );
                $pdo->setAttribute( \PDO::ATTR_ERRMODE,
                    \PDO::ERRMODE_EXCEPTION );
                return $pdo;
            } catch( \Exception $e ) {
                return [
                    'error' => $e->getCode(),
                    'message' => $e->getMessage()
                ];
            }
        }

       /*
        |--------------------------------------------------------------------------
        | select method
        |--------------------------------------------------------------------------
        |
        | The select method accepts a query string and parameters ( when submitted )
        | for processing with mysql. The select method passes all arguments to
        | the engine method for execution. All exceptions are handle. If there are
        | no exceptions, the requested results are returned.
        |
        | @example   Database::select( 'select field from table
        |                               where value =:argument ',
        |                               [ 'argument' => $argument ] );
        |
        */
        public static function select( string $query, array $params ) {
            return static::engine( $query, $params, 'SELECT' );
        }

       /*
        |--------------------------------------------------------------------------
        | insert method
        |--------------------------------------------------------------------------
        |
        | The insert method accepts a set of arguments including the table name,
        | table key/value pairing, insert specific arguments and parameters
        | ( when submitted ) for processing in mysql. The insert method
        | passes all arguments to the engine method for execution. All
        | exceptions are handle. If there are no exceptions, the
        | requested results are returned.
        |
        | @example   Database::insert( 'table_name',
        |                              [ 'key1' => 'value1',
        |                                'key2' => 'value2',
        |                                'key3' => 'value3' ] );
        |
        */
        public static function insert( string $table, array $params, $flags = false ) {
            $query = 'INSERT '. ( !empty( $flags ) ?? 'IGNORE' )
                     . 'INTO '. $table
                     . ' ('. implode( ',', array_keys( $params ) ) .' ) '
                     . ' VALUES( :'. implode( ',:', array_keys( $params ) )
                     .') ';
            return static::engine( $query, $params, 'INSERT' );
        }

       /*
        |--------------------------------------------------------------------------
        | update method
        |--------------------------------------------------------------------------
        |
        | The update method accepts a set of arguments including the table name,
        | table key/value pairing for fields that will be updated, condition under
        | which the update is to be applied, and any parameters that need to be
        | bound to the statement. The update method passes all arguments to the
        | engine method for execution. All exceptions are handle. If there are no
        | exceptions, the requested results are returned.
        |
        | @example   Database::update( 'table',
        |                              [ 'key1' => 'value1',
        |                                'key2' => 'value2',
        |                                'key3' => 'value3' ],
        |                              'where field1 =:argument1
        |                               and field2 =:argument2   ',
        |                               [ 'argument1' => $argument1,
        |                                 'argument2' => $argument2 ] );
        |
        */
        public static function update( string $table, array $set, string $conditions, array $params ) {
            $count = 1;
            $query = 'UPDATE '. $table .' SET ';
            foreach( $set as $key => $value ):
                $query .= $key .' = "'.$value.'"';
                $query .= ( $count < sizeof($set) ) ? ', ' : null;
                ++$count;
            endforeach;
            $query .= $conditions;
            return static::engine( $query, $params, 'UPDATE' );
        }

       /*
        |--------------------------------------------------------------------------
        | delete method
        |--------------------------------------------------------------------------
        |
        | The delete method accepts a set of arguments including the table name,
        | condition under which the delete is to be executed and any parameters to
        | be bound to the statement. The delete method passes all arguments to the
        | engine method for execution. All exceptions are handle. If there are no
        | exceptions, the requested results are returned.
        |
        | @example   Database::delete( 'table',
        |                              'where field1 =:argument1 ',
        |                               [ 'argument1' => $argument1 ] );
        |
        */
        public static function delete( string $table,string $conditions,array $params ) {
            $query = 'DELETE '. $table . ' ' . $conditions;
            return static::engine( $query, $params, 'DELETE' );
        }

       /*
        |--------------------------------------------------------------------------
        | aggregate method
        |--------------------------------------------------------------------------
        |
        | The delete method accepts a set of arguments including the table name,
        | condition under which the max is to be executed and any parameters to
        | be bound to the statement. The delete method passes all arguments to the
        | engine method for execution. All exceptions are handle. If there are no
        | exceptions, the requested results are returned.
        |
        | @var $acceptedFunctions [
        |          'SUM',
        |          'COUNT',
        |          'AVG',
        |          'MAX',
        |          'MIN'
        |    ]
        | @example   Database::aggregate( 'table',
        |                                 'money',
        |                                 'SUM',
        |                                 'where field1 =:argument1 ',
        |                               [ 'argument1' => $argument1 ] );
        |
        */
        public static function aggregate( string $table, string $field, string $function, string $conditions,
                                          array $params ) {
            $acceptedFuncs = [
                'SUM',
                'COUNT',
                'AVG',
                'MAX',
                'MIN'
            ];
            if ( !in_array( $function, $acceptedFuncs ) ) :
                return 'Function Specified is not available';
            endif;
            $query = 'SELECT '. Str::allcaps( $function ) .'('. $field .') as aggregate FROM '. $table . ' '
                . $conditions;
            return static::engine( $query, $params, 'AGGREGATE' );
        }

       /*
        |--------------------------------------------------------------------------
        | engine method
        |--------------------------------------------------------------------------
        |
        | The engine method creates a PDO instance, connects to the database,
        | prepares a statement, creates the necessary bindings while ensuring
        | that the correct PDO Param Type is specified.  The engine method then
        | executes the statement and depending on the action, it will return
        | a specific set of results.  The engine method will also handle
        | exceptions and return the appropriate error
        |
        */

        public static function engine( string $query, array $params, string $action ) {
            $pdo = static::connect();
            $statement = $pdo->prepare( $query );
            if ( !empty( $params ) ) :
                $types  =   [
                    'boolean' => \PDO::PARAM_BOOL,
                    'double' => \PDO::PARAM_STR,
                    'int' => \PDO::PARAM_INT,
                    'null' => \PDO::PARAM_NULL,
                    'string' => \PDO::PARAM_STR
                ];

                foreach( $params as $key => $value ) :
                    if ( in_array( gettype( $value ), $types ) ):
                        $statement->bindParam( $key, $value, $types[ gettype( $value ) ] );
                    else:
                        $statement->bindParam( $key, $value, \PDO::PARAM_STR );
                    endif;
                    unset( $key, $value );
                endforeach;
            endif;

            try {
                $statement->execute();
                return static::prep( $action, $statement, $pdo );
            } catch( \PDOException $e ) {
                if ( $_ENV['DB_DEBUG'] == true ) :
                    $console = [
                        'error' => $e->errorInfo[1],
                        'message' => $e->getMessage(),
                        'action' => $action,
                        'file' => $e->getTrace()[2]['file'],
                        'line' => $e->getTrace()[2]['line'],
                        'query' => ( !empty( $e->getTrace()[2]['args'][0] )
                            ?? $e->getTrace()[2]['args'][0] ),
                        'args' => ( !empty( $e->getTrace()[2]['args'][1] )
                            ?? $e->getTrace()[2]['args'][1] )
                    ];
                    $browser  =  null;
                    $browser .=  '<script>tribe.log(';
                    $browser .=  json_encode( $console,
                        JSON_HEX_TAG|JSON_PRETTY_PRINT|JSON_FORCE_OBJECT );
                    $browser .=  ');</script>';
                    echo $browser;
                endif;
                return [
                    'error' => $e->errorInfo[1],
                    'message' => $e->getMessage()
                ];
            }
        }

       /*
        |--------------------------------------------------------------------------
        | prep method
        |--------------------------------------------------------------------------
        |
        | The prep method determines the action for the request and then returns
        | the response with the appropriate key/value pairing
        |
        */
        public static function prep( string $action, object $statement, object $pdo ) {
            $errno = ( ( $statement->errorCode() == 00000 ) ? 0 :
                $statement->errorCode() );
            if ( $action == 'SELECT' ) :
                return [
                    'error' => $errno,
                    'count' => $statement->rowCount(),
                    'data' => $statement->fetchAll( \PDO::FETCH_ASSOC )
                ];
            elseif ( $action == 'INSERT' ) :
                return [
                    'error' => $errno,
                    'insertID' => $pdo->lastInsertId()
                ];
            elseif ( $action == 'UPDATE' ) :
                return [
                    'error' => $errno,
                    'affected' => $statement->rowCount()
                ];
            elseif ( $action == 'DELETE' ) :
                return [
                    'error' => $errno,
                    'affected' => $statement->rowCount()
                ];
            elseif ( $action == 'AGGREGATE' ) :
                return [
                    'error' => $errno,
                    'aggregate' =>
                        $statement->fetchAll( \PDO::FETCH_ASSOC  )[0]['aggregate']
                ];
            endif;
        }
    }