<?php

    namespace app\core;
    use app\core\Application;
    use app\core\exception\NotFoundException;
    use app\core\middleware\Middleware;
    use app\helpers\Str;
    use app\helpers\Arr;

    /*
     |------------------------------------------------------------------------
     | Tribe Framework : Class Route
     |------------------------------------------------------------------------
     |
     | @author:         Vincent J. Rahming <vincent@genesysnow.com>
     |
     | @description:    The Route Class orchestrates routing within the Tribe
     |                  Framework and is responsible for handling get and
     |                  post requests as well as resolving routes and
     |                  ensuring that special conditions for route
     |                  variables as well as route rules are
     |                  applied when they are specified
     |
     | @package:        app\core
     |
     | @version:        1
     |
     |------------------------------------------------------------------------
     */

    class Route {

        public Request $request;
        public View $view;
        public static string $alias = '';
        public static array $aliasmap = [];
        public static string $aliaspath = '';
        protected string $defaultLogin = 'auth';
        public static array $routemaps = [];
        public static array $routes = [];
        public static string $rulepath = '';
        protected static $callback = null;
        protected static $prefixValue = null;
        protected static $middlewares = null;
        protected static array $this = [];

        /**
         * @param Request $request
         * @param View $view
         */

        public function __construct( Request $request, View $view, $prefix = null, $path = false, $method = false,
            $type = false, $callback = null, $middleware = null
        ) {
            $this->request = $request;
            $this->view = $view;
//            $this->method = '';
            if ( !empty( $prefix ) ) :
//                $this->prefix = $prefix;
                self::$prefixValue = $prefix;
            endif;
            if ( !empty( $path ) ) :
//                $this->path = $path;
            endif;
            if ( !empty( $method ) ) :
//                $this->method = $method;
            endif;
            if ( !empty( $type ) ) :
                $this->type = $type;
            endif;
            if ( !empty( $callback ) ) :
                self::$callback = $callback;
            endif;
            if ( !empty( $middleware ) ) :
                self::$middlewares = $middleware;
            endif;
            self::$this = ( array )$this;
        }

       /*
        |--------------------------------------------------------------------------
        | controller
        |--------------------------------------------------------------------------
        |
        | allows routes to be grouped by a single controller
        |
        | @var string $controller
        |
        | @example Route::controller(IndexController::class)->group(function(){
        |                   Route::get( '/hello/world', 'hello' );
        |               });
        |
        */
        public static function controller($controller) {
            return new static(
                self::$this['request'],
                self::$this['view'],
                callback: $controller );
        }

       /*
        |--------------------------------------------------------------------------
        | get
        |--------------------------------------------------------------------------
        |
        | returns the Route object and resolve all get routes defined in the
        | web.php file
        |
        | @var string $path
        |
        | @var string $callback
        |
        | @example Route::get( '/', [IndexController::class,'index']);
        |
        | @result: Object of app\core\Route Class
        |
        */
        public static function get($path,$callback) {
            if (!empty(self::$middlewares)):
                if( Str::is(self::$middlewares)) :
                    $type = ( Arr::isassoc(Middleware::registerMiddleware())
                    == true ? 'isassoc' : 'indexed');
                    if ( !Arr::contains(self::$middlewares, Middleware::registerMiddleware(),$type)):
                          error(
                              message: self::$middlewares .' is not registered',
                              httpstatus: 403
                          );
                    endif;
                    $middlewareClass = Middleware::registerMiddleware()[
                        self::$middlewares
                    ];
                    $middlewareClass = new $middlewareClass;
                    $middlewareClass->execute();
                    self::$middlewares = null;
                else:
                    $type = ( Arr::isassoc(Middleware::registerMiddleware())
                    == true ? 'isassoc' : 'indexed');
                    foreach(self::$middlewares as $middleware ):
                        if ( !Arr::contains($middleware, Middleware::registerMiddleware(), $type )):
                            error(
                                code: 1,
                                message: self::$middlewares .' is not registered',
                                httpstatus: 403
                            );
                        endif;
                        $middlewareClass = Middleware::registerMiddleware()[
                            $middleware
                        ];
                        $middlewareClass = new $middlewareClass;
                        $middlewareClass->execute();
                    endforeach;
                endif;
            endif;
            if ( gettype($callback) === 'string' ):
                if ( !empty( self::$callback ) ):
                    $callback = [
                        self::$callback,
                        $callback
                    ];
                endif;
            endif;
            if( !empty(self::$prefixValue) ):
                $path = '/'. self::$prefixValue . $path;
            endif;
            addroute( 'get', $path, $callback );
//            self::$middlewares = null;
            return new static(
                self::$this['request'],
                self::$this['view'],
                path: $path,
                method: 'get',
                 );
        }

        public static function middleware( string|array $argument ) {
            self::$middlewares = $argument;
            return new static( self::$this['request'], self::$this['view']);
        }

        /*
        |--------------------------------------------------------------------------
        | prefix
        |--------------------------------------------------------------------------
        |
        | checks the prefix and then prepends it to the declared path and adds
        | a new route
        |
        | @var string $prefix
        |
        */
        public static function prefix(string $prefix) {
            return new static( self::$this['request'], self::$this['view'], prefix: $prefix );
        }

       /*
        |--------------------------------------------------------------------------
        | post
        |--------------------------------------------------------------------------
        |
        | returns the Route object and resolve all post routes defined in the
        | web.php file
        |
        | @var string $path
        |
        | @var string $callback
        |
        | @example Route::post( '/', [IndexController::class,'index']);
        |
        | @result: Object of app\core\Route Class
        |
        */
        public static function post( $path, $callback ) {
            if ( gettype($callback) === 'string' ):
                if ( !empty( self::$callback ) ):
                    $callback = [
                        self::$callback,
                        $callback
                    ];
                endif;
            endif;
            if( !empty(self::$prefixValue) ):
                $path = '/'. self::$prefixValue . $path;
            endif;
            addroute( 'post', $path, $callback );
            self::$this['path'] = $path;
            return new static(
                self::$this['request'],
                self::$this['view'],
                path: $path,
                method: 'get',
                callback: $callback
            );
        }

       /*
        |--------------------------------------------------------------------------
        | resource
        |--------------------------------------------------------------------------
        |
        | returns the Route object and resolve all post routes defined in the
        | web.php file
        |
        | @var string $path
        |
        | @var string $callback
        |
        | @example Route::post( '/', [IndexController::class,'index']);
        |
        | @result: Object of app\core\Route Class
        |
        */
        public static function resource($callback, $prefix ) {
            createresource( $callback, $prefix );
            return new static(
                self::$this['request'],
                self::$this['view'],
                prefix: $prefix,
                type: 'fullstack'
            );
        }

       /*
        |--------------------------------------------------------------------------
        | resolves routes
        |--------------------------------------------------------------------------
        |
        | resolve permits the framework to accept a route with arguments and then
        | determine route segments, route variables and how to determine which
        | view to associate with the specified route
        |
        */
        public function resolve() {
            return callback(
                $this->request->method(),
                $this->request->getURLPath(),
                $this->view,
                $this->request
            );
        }

//        public function middleware( string|array $middleware ) {
//            if( Str::is($middleware) ) :
//                $type = ( Arr::isassoc(Middleware::registerMiddleware()) == true
//                    ? 'isassoc' : 'indexed');
//                if ( !Arr::contains($middleware, Middleware::registerMiddleware(), $type )):
//                      echo 'Middleware not registered';
//                endif;
//                $middlewareClass = Middleware::registerMiddleware()[$middleware];
//                $middlewareClass = new $middlewareClass;
//                $middlewareClass->execute();
//            endif;
//            return new static( self::$this['request'], self::$this['view'] );
//        }

       /*
        |--------------------------------------------------------------------------
        | alias
        |--------------------------------------------------------------------------
        |
        | renames the path to the alias value instead of the defined name in the
        | router call
        |
        | @var string alias
        | path: self::$this['path']
        */
        public function alias( string $alias ) {
            if ( !empty( $alias ) ) :
                self::$alias = $alias;
                self::$aliasmap[$alias] = self::$aliaspath;
            endif;
            return new static( self::$this['request'], self::$this['view']);
        }

       /*
        |--------------------------------------------------------------------------
        | auth
        |--------------------------------------------------------------------------
        |
        | Ensures that route rules are applied for get and post methods. Rules
        | include AUTH | ACCESS_CONTROL | ect
        |
        | @var string|array $rule
        |
        | @example STRING enforce( 'AUTH' );
        |
        | @example ARRAY enforce( ['ruleName' => ['ruleArgument', 'ruleArgument' ]
        |
        */
        public function auth() {
            $varpath = NULL;
            if ( isset( route( self::$rulepath )['vars'] ) ) :
                $vars = [];
                foreach( route( self::$rulepath )['vars'] as $var ) :
                    $vars[] = Arr::values( $var )[0];
                endforeach;
                $varpath = '/'. implode('/', $vars );
            endif;
            if ( path() === route( self::$rulepath )['path'] . $varpath ) :
                if ( ! session('UserAuthenticated') ) :
                    addSession( 'LoadURLOnAuth', path() );
                    redirect( '/'. $this->defaultLogin );
                endif;
            endif;
            return new static( self::$this['request'], self::$this['view'] );
        }

       /*
        |--------------------------------------------------------------------------
        | except
        |--------------------------------------------------------------------------
        |
        | works with route stacks and acts filter. all route the methods specified
        | that are available in a default stack will be provided except for the
        | methods specified in the rule.
        |
        | @var STRING|ARRAY $rule
        |
        */
        public function except( string|array $rule ) {
            if ( isset( self::$this['type'] ) ) :
                $type = self::$this['type'];
                if ( Arr::is( $rule ) ) :
                    foreach(Route::$routes as $key => $value ) :
                        foreach( $value as $controller => $method ) :
                            if ( str_contains( $controller, self::$this['prefix'] ) ):
                                if( in_array( $method[1], $rule ) ) :
                                    unset( Route::$routes[$key][$controller] );
                                endif;
                            endif;
                        endforeach;
                    endforeach;
                else:
                    foreach(Route::$routes as $key => $value ) :
                        foreach( $value as $controller => $method ) :
                            if ( str_contains( $controller, self::$this['prefix'] ) ):
                                if( $method[1] == $rule ) :
                                    unset( Route::$routes[$key][$controller] );
                                endif;
                            endif;
                        endforeach;
                    endforeach;
                endif;
            else:
                $type = null;
            endif;
            return new static( self::$this['request'], self::$this['view'], type: $type );
        }

        public function group($routes) {
            call_user_func($routes);
            self::$prefixValue = null;
            self::$middlewares = null;
            return new static(self::$this['request'], self::$this['view']);
        }

        /*
         |--------------------------------------------------------------------------
         | only
         |--------------------------------------------------------------------------
         |
         | works with route stacks and acts filter. only the methods specified in
         | the rule variable will be displayed.
         |
         | @var STRING|ARRAY $rule
         |
         */
        public function only( string|array $rule ) {
            if ( isset( self::$this['type'] ) ) :
                $type = self::$this['type'];
                if ( Arr::is( $rule ) ) :
                    foreach(Route::$routes as $key => $value ) :
                        foreach( $value as $controller => $method ) :
                            if ( str_contains( $controller, self::$this['prefix'] ) ):
                                if( !in_array( $method[1], $rule ) ) :
                                    unset( Route::$routes[$key][$controller] );
                                endif;
                            endif;
                        endforeach;
                    endforeach;
                else:
                    foreach(Route::$routes as $key => $value ) :
                        foreach( $value as $controller => $method ) :
                            if ( str_contains( $controller, self::$this['prefix'] ) ):
                                if( $method[1] != $rule ) :
                                    unset( Route::$routes[$key][$controller] );
                                endif;
                            endif;
                        endforeach;
                    endforeach;
                endif;
            else:
                $type = null;
            endif;
            return new static( self::$this['request'], self::$this['view'], type: $type );
        }

        /*
         |--------------------------------------------------------------------------
         | where
         |--------------------------------------------------------------------------
         |
         | checks the constraints that are applied to a route from the regular
         | expression that get submitted.  using regular expressions provides
         | flexibility when applying constraints
         |
         | @var array $constraints
         |
         */
        public function where( array $contraints ) {
            if ( !empty( $contraints ) ) :
                if ( !empty( routeParams() ) ) :
                    foreach( routeParams() as $key => $value ) :
                        if ( in_array( $key, array_keys( $contraints ) ) ) :
                            if ( preg_match( "/". $contraints[$key] ."/",
                                    $value ) == 0 ) :
                                throw new \Exception( 'Variable: '. $key .
                                    ' constraint mismatch' );
                            endif;
                        endif;
                    endforeach;
                endif;
            endif;
            return new static(self::$this['request'], self::$this['view']);
        }
    }