<?php

    namespace app\core;
    use app\core\middleware\AuthMiddleware;

    use app\core\middleware\CsrfMiddleware;

    /*
     |------------------------------------------------------------------------
     | Tribe Framework : Class Controller
     |------------------------------------------------------------------------
     |
     | @author:         Vincent J. Rahming <vincent@genesysnow.com>
     |
     | @description:    The Controller Class  ...
     |
     | @package:        app\core
     |
     | @version:        1
     |
     |------------------------------------------------------------------------
     */
//    #[AllowDynamicProperties]
    class Controller {

        public string $layout = 'master';
        public string $notfound = '_error';
        public string $auth = 'login';
        public string $action = '';
        public $model = '';




        public function render ( $view, $params = [] ) {
            return Application::$app->view->renderView( $view, $params );
        }

        public function setLayout( $layout ) {
            $this->layout = $layout;
        }

//        public function registerMiddleware( BaseMiddleware $middleware ) {
//            $this->middleware[] = $middleware;
//        }
//
//        /**
//         * @return BaseMiddleware[]
//         */
//        public function getMiddleware(): array {
//            return $this->middleware;
//        }

    }