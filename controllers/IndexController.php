<?php

    namespace app\controllers;
    use app\core\Controller;
    use app\core\Request;
    use app\core\Model;
    use app\models\IndexModel;
//    use AllowDynamicProperties;


    class IndexController extends Controller {

        private string $folder = 'Index';

        public function __construct() {
            $this->setLayout( 'default' );
        }

        public function index() {
            return render( $this->folder . '.Index', [] );
        }

    }