<?php

    namespace app\core;
    use app\helpers\Str;
    use app\core\Controller;

    class View {

        public string $title = '';
        public string $keywords = '';
        public string $description = '';

        public function renderView( $view, $params = false ) {
            Security::validateCSRF();
            $setView = $this->setContent( $view, $params );
            $setLayout = $this->setLayout();
            return Str::replace( '{{content}}', $setView, $setLayout );
        }

        public function setContent( $view, $params ) {
            try {
                if (!empty($params)) :
                    foreach ($params as $key => $value) :
                        $$key = $value;
                    endforeach;
                endif;
            } catch( \RuntimeException $e ) {
                var_dump( $e );
            }
            ob_start();
            include_once views( $view );
            return ob_get_clean();
        }

        public function setLayout() {
            ob_start();
            if ( !isset( Application::$app->controller->layout ) ) :
                $layout = $_ENV['TRIBE_DEFAULT_VIEW_LAYOUT'];
            else:
                $layout = Application::$app->controller->layout;
            endif;
            include_once layouts(  $layout );
            return ob_get_clean();
        }

        public function renderError() {
            ob_start();
            $layout = $_ENV['TRIBE_DEFAULT_VIEW_ERROR'];
            include_once layouts(  $layout );
            return ob_get_clean();
        }

        public function renderNotFound() {
            $this->title = 'Page Not Found';
            include_once notfound();
        }
    }