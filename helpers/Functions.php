<?php

    use app\core\Application;
    use app\core\Route;
    use app\helpers\Arr;
    use app\helpers\Str;
    use app\core\exception\NotFoundException;

   /*
    |--------------------------------------------------------------------------
    | addRoute
    |--------------------------------------------------------------------------
    |
    | adds/registers defined routes and then maps them to be resolved. this
    | helper function also handles variables that get passed in the URL
    |
    | @var string $method
    |
    | @var string $path
    |
    | @var string $callback
    |
    | @example addRoute( 'get', '/register/me/{id}/{id}', [IndexController::class,'index'] );
    |
    */
    function addRoute( $method, $path, $callback ) {
        Route::$rulepath = $path;
        Route::$aliaspath = $path;
        if ( strlen( $path ) > 1 ) :
            $path = Str::righttrim( '/', $path );
        endif;
        $path = route( $path );
        Route::$routes[$method][$path['path']] = $callback;
        addRouteToMap($method, $path);
    }

   /*
    |--------------------------------------------------------------------------
    | addRouteToMap
    |--------------------------------------------------------------------------
    |
    | adds defined to a map so that the system can easily resolve the requests
    |
    | @var string $path
    |
    | @example addRouteToMap( '/register/me/{id}/{id}' );
    |
    */
    function addRouteToMap($method,$path) {
        if ( sizeof($path) == 1 ):
            if ( isset( Route::$routemaps[$method] ) ) :
                if( !in_array( $path['path'], Arr::keys( Route::$routemaps[$method] ) ) ) :
                    Route::$routemaps[$method][$path['path']] = $path;
                endif;
            else:
                Route::$routemaps[$method][$path['path']] = $path;
            endif;
        else:
            $vars = [];
            foreach( $path['vars'] as $set ) :
                $vars[] = array_values($set)[0];
            endforeach;
            $pathmap = $path['path'] .'/'. implode( '/', $vars );
            Route::$routemaps[$method][$pathmap] = $path;
        endif;
    }

   /*
    |--------------------------------------------------------------------------
    | addSession
    |--------------------------------------------------------------------------
    |
    | adds a session key / pair value to the $_SESSION superglobal array
    |
    | @var string $key
    |
    | @var string $value
    |
    | @example addSession( $key, $value );
    |
    |
    */
    function addSession( $key, $value ) {
        if ( !empty( $key ) AND
             !empty( $value ) ) :
            $_SESSION[$key] = $value;
        else:
            return null;
        endif;
    }

   /*
    |--------------------------------------------------------------------------
    | callback
    |--------------------------------------------------------------------------
    |
    | callback determines if the path specified is either defined or exists as
    | an alias. If the path is neither specified or declared to be an alias
    | the function returns a failed response.
    |
    | @var string $method
    |
    | @var string $path
    |
    | @example callback( $method, $path );
    |
    */
    function callback( $method, $path, $view, $request ) {
        if(!isset(Route::$routemaps[ $method ][ $path ]['path'] ) ) :
            if(isset(Route::$aliasmap[ Str::lefttrim( '/', $path) ] ) ) :
                $callback = Route::$routes[ $method ][ Route::$aliasmap[ Str::lefttrim( '/', $path) ] ];
            else:
                $callback = false;
            endif;
        else:
            $callback = Route::$routes[ $method ][ Route::$routemaps[ $method ][ $path ]['path']
                ?? false ] ?? false;
        endif;
        if ( Str::is( $callback ) ) :
            return $view->renderView( $callback );
        elseif( Arr::is( $callback ) ) :
            $controller = new $callback[0]($request);
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;
//            foreach($controller->getMiddleware() as $middleware) :
//                $middleware->execute();
//            endforeach;
            return call_user_func_array($callback, routeParams());
        elseif (is_object($callback)) :
            return call_user_func($callback);
        else:
            setHttpStatusCode( 404 );
            return $view->renderNotFound();
        endif;
    }

   /*
    |--------------------------------------------------------------------------
    | createstack
    |--------------------------------------------------------------------------
    |
    | adds/registers defined routes and then maps them to be resolved. this
    | helper function also handles variables that get passed in the URL
    |
    | @var string $method
    |
    | @var string $path
    |
    | @var string $callback
    |
    | @example addRoute( 'get', '/register/me/{id}/{id}', [IndexController::class,'index'] );
    |
    */
    function createresource( $callback, $prefix ) {
        $resourceRoutes =
            [
                ['/', 'index','get'],
                ['/create', 'create','post'],
                ['/show/:id','show','get'],
                ['/edit/:id','edit','get'],
                ['/update/:id','update','post'],
                ['/delete/:id','delete','get'],
                ['/destroy/:id','destroy','post']
            ];
        foreach($resourceRoutes as $resourceRoute ) :
            Route::$rulepath = Str::righttrim( '/','/'. $prefix . $resourceRoute[0] );
            Route::$aliaspath = Str::righttrim( '/','/'. $prefix . $resourceRoute[0] );
            if ( strlen( '/'. $prefix . $resourceRoute[0] ) > 1 ) :
                $path = Str::righttrim( '/', '/'. $prefix . $resourceRoute[0] );
            else:
                $path = '/'. $prefix . $resourceRoute[0];
            endif;
            $path = route( $path );
            Route::$routes[$resourceRoute[2]][$path['path']] = [ $callback, $resourceRoute[1] ];
            addRouteToMap( $resourceRoute[2], $path );
        endforeach;
    }

    function domain() {
        return $_SERVER['HTTP_ORIGIN'];
    }

   /*
    |--------------------------------------------------------------------------
    | isUserAuthenticated
    |--------------------------------------------------------------------------
    |
    | isUserAuthenticated checks to see if the session with the same name has
    | been actiaved and then returns a boolean true or false response based
    | on the result
    |
    | @example isUserAuthenticated();
    |
    */
    function isUserAuthenticated(): bool {
        if (session('UserAuthenticated')):
            return true;
        endif;
        return false;
    }

    function method() {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

   /*
    |--------------------------------------------------------------------------
    | redirect
    |--------------------------------------------------------------------------
    |
    | redirects to the specified URL
    |
    | @var string $url
    |
    | @example redirect( $url );
    |
    */
    function redirect( string $url ) {
        header('Location: ' . $url );
    }

    /*
     |--------------------------------------------------------------------------
     | render
     |--------------------------------------------------------------------------
     |
     | displays the specified view and loads all parameters that are associated
     | with it
     |
     | @var string $view
     |
     | @var OPTIONAL array $params
     |
     | @example render( $view, $params );
     |
     */
    function render( string $view, $params = [] ) {
        return Application::$app->view->renderView( $view, $params );
    }

   /*
    |--------------------------------------------------------------------------
    | route
    |--------------------------------------------------------------------------
    |
    | processes the route path as specified in the routes file. This function
    | will determine which part of the url is a route segment and which part
    | is a route variable.  It will parse the path accordingly and then
    | return a package ( array ) containing a path and possibly a
    | list of variables ( if route variables are defined ).
    |
    | @var string $path
    |
    | @example route( $path );
    |
    */
    function route( $path ) : array {
        $components =  explode( '/', Str::lefttrim( '/', $path ) );
        $package = [];
        if ( Arr::size( $components ) == 1 ) :
            $package = [ 'path' => '/'. $components[0] ];
        else:
            $newpath = [];
            $vars = [];
            $position = 0;
            foreach( $components as $component ) :
                if ( substr( $component, 0, 1 ) != ':' ) :
                    $newpath[] = $component;
                else:
//                    $component = Str::righttrim('}',
//                          Str::lefttrim( '{', $component ) );
                    $component = Str::lefttrim( ':', $component );
                    $url = explode( '/', ( Str::lefttrim( '/',
                        $_SERVER['REQUEST_URI'] ) ) )[ $position ] ?? false;
                    if((gettype($component) === 'string' ) && !empty( $component )):
                        array_push( $vars, [ $component => $url ] );
                    endif;
                endif;
                ++$position;
            endforeach;

            $package =
                [
                    'path' => '/'. implode( '/', $newpath ),
                ];
            if ( !empty( $vars ) ) :
                $package['vars'] = $vars;
            endif;
        endif;

//        print_r( $package );
        return $package;
    }

   /*
    |--------------------------------------------------------------------------
    | routeParams
    |--------------------------------------------------------------------------
    |
    | passed any defined route parameters to the view.
    |
    | @example routeParams();
    |
    | @result: array | null
    |
    */
    function routeParams() {
        $routeParams = [];
//        echo gettype( Route::$routemaps[method()][
//        route( $_SERVER['REQUEST_URI'] )['path']
//        ]['vars'] );
        if (!empty(Route::$routemaps[method()][
                    route( $_SERVER['REQUEST_URI'] )['path']
                    ]['vars'])):
            foreach(Route::$routemaps[method()][
                    route( $_SERVER['REQUEST_URI'] )['path']
                    ]['vars'] as $key => $value ):

                $routeParams[array_keys($value)[0]] = array_values($value)[0];
            endforeach;
        endif;
        return $routeParams;
    }

    /*
    |--------------------------------------------------------------------------
    | setHttpStatusCode
    |--------------------------------------------------------------------------
    |
    | sets the HttpStatusCode
    |
    | @statusCode INT
    |
    | @example setHttpStatusCode( $statusCode );
    |
    */
    function setHttpStatusCode( int $statusCode ) {
        http_response_code( $statusCode );
    }

    /*
     |--------------------------------------------------------------------------
     | datadump
     |--------------------------------------------------------------------------
     |
     | returns a var_dump of the specified variable
     |
     | var $data MIXED
     |
     | @example datadump( $data );
     |
     */
    function datadump( $data ) {
        echo '<pre>';
        var_dump( $data );
        echo '</pre>';
    }

    /*
     |--------------------------------------------------------------------------
     | layouts
     |--------------------------------------------------------------------------
     |
     | returns directory where views will be stored
     |
     | @example layouts()
     |
     */
    function layouts( $file ) {
        if ( file_exists( root() .'/resources/layouts/' . $file.'.php') )  :
            return root() .'/resources/layouts/'. $file .'.php';
        endif;
        return root() .'/resources/layouts/main.php';
    }

    function notfound() {
        return root() .'/resources/layouts/notfound.php';
    }

    function path() {
        if ( strlen( $_SERVER['REQUEST_URI'] ) > 1 ) :
            return str::righttrim('/', $_SERVER['REQUEST_URI'] );
        else:
            return $_SERVER['REQUEST_URI'];
        endif;
    }

    /*
     |--------------------------------------------------------------------------
     | resources
     |--------------------------------------------------------------------------
     |
     | returns root directory path of the server
     |
     | @example resources()
     |
     */
    function resources() {
        return dirname( __DIR__ ) .'/resources';
    }

   /*
    |--------------------------------------------------------------------------
    | root
    |--------------------------------------------------------------------------
    |
    | returns root directory path of the server
    |
    | @example root()
    |
    */
    function root() {
        return dirname( __DIR__ );
    }

    /*
     |--------------------------------------------------------------------------
     | session
     |--------------------------------------------------------------------------
     |
     | returns the value of the specified session key
     |
     | @example session( $key );
     |
     */
    function session($key) {
        return $_SESSION[$key] ?? false;
    }

    /*
     |--------------------------------------------------------------------------
     | url
     |--------------------------------------------------------------------------
     |
     | returns the current url path
     |
     | @example url();
     |
     */
    function url() {
        return ( !isset( $_SERVER['HTTPS'] ) ? 'http://' : 'https' ) . $_SERVER['HTTP_HOST'];
    }

    /*
     |--------------------------------------------------------------------------
     | views
     |--------------------------------------------------------------------------
     |
     | returns directory where views will be stored
     |
     | @example views()
     |
     */
    function views( $view ) {
        if ( file_exists( root() .'/resources/views/' .
            Str::replace( '.', '/', $view ) .'.php') ) :
            return root() .'/resources/views/' . Str::replace( '.', '/', $view ) .'.php';
        endif;
        return root() .'/resources/views/' . Str::replace( '.', '/', Application::
            $app->controller->notfound ) .'.php';
    }

    function error( $code = false, $message = false, $httpstatus = false ) {
        echo $code .' '. $message;
        exit();
    }