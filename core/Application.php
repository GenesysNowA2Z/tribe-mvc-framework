<?php

    namespace app\core;
    use app\core\exception\ForbiddenException;

    class Application {

        public static string $ROOT_DIR;
        public string $userClass;
        public string $layout = 'main';
        public static Application $app;
        public Controller $controller;
        public Database $database;
        public Request $request;
        public Response $response;
        public Route $router;
        public Security $security;
        public Session $session;
        public View $view;

        public function __construct() {
            self::$app = $this;
            $this->request = new Request();
            $this->response = new Response();
            $this->session = new Session();
            $this->view = new View();
            $this->security = new Security();
            Security::csrf();
            $this->router = new Route( $this->request, $this->view );
        }

        public function launch() {
            try {
                echo $this->router->resolve();
            } catch ( \Exception $e ){
                echo $this->view->renderView( '_error', [
                    'exception' => $e
                ]);
            }
        }

        /**
         * @return Controller
         */
        public function getController(): Controller {
            return $this->controller;
        }

        /**
         * @param Controller $controller
         */
        public function setController( Controller $controller ): void {
            $this->controller = $controller;
        }

        public static function isGuest() {
//            return !self::$app->user;
        }

    }