<?php

    namespace app\core;

    class Console {
        protected static $controllerDefaultMethods = [
            'index' => [
                'desc' => 'main entry page',
                'id' => false,
                'params' => true,
                'return' => true
            ],
            'create' => [
                'desc' => 'creates new record or row',
                'id' => false,
                'params' => true,
                'return' => true
            ],
            'show' => [
                'desc' => 'view/read record or row',
                'id' => true,
                'params' => true,
                'return' => true
            ],
            'save' => [
                'desc' => 'commits changes to database for a record or row',
                'id' => true,
                'params' => true,
                'return' => false
            ],
            'update' => [
                'desc' => 'displays update page for record or row updated',
                'id' => true,
                'params' => true,
                'return' => true
            ],
            'delete' => [
                'desc' => 'displays delete page for record or row to be deleted',
                'id' => true,
                'params' => true,
                'return' => true
            ],
            'destroy' => [
                'desc' => 'displays page for record or row to be removed',
                'id' => true,
                'params' => true,
                'return' => false
            ]
        ];

        protected static $controllerPath = 'controllers';
        protected static $modelPath = 'models';

        public static function createController(string $argument){
            $root = dirname(__DIR__ ) .'/'. self::$controllerPath .'/';
            if(!file_exists($root . $argument .'.php')):
                try {
                    $file = fopen($root . $argument . '.php', 'x+');
                    fwrite($file, '<?php' . PHP_EOL);
                    fwrite($file, PHP_EOL);
                    fwrite($file, "\t");
                    fwrite($file, 'namespace app\controllers;' . PHP_EOL);
                    fwrite($file, "\t");
                    fwrite($file, 'use app\core\Controller;' . PHP_EOL);
                    fwrite($file, "\t");
                    fwrite($file, 'use app\core\Request;' . PHP_EOL);
                    fwrite($file, PHP_EOL);
                    fwrite($file, "\t");
                    fwrite($file, 'class ' . $argument . ' extends Controller {' . PHP_EOL);
                    fwrite($file, "\t\t");
                    fwrite($file, 'public function __construct(){' . PHP_EOL);
                    fwrite($file, "\t\t\t");
                    fwrite($file, '$request = new Request();' . PHP_EOL);
                    fwrite($file, "\t\t");
                    fwrite($file, '}' . PHP_EOL);

                    fwrite($file, "\t");
                    fwrite($file, '}' . PHP_EOL);
                    fwrite($file, '?>');
                    fclose($file);
                    return 1;
                } catch(\Exception $e){
                    var_dump($e);
                    return 3;
                }
            else:
                return 2; // file already exits
            endif;
        }

        public static function createResource(string $argument){
            $root = dirname(__DIR__ ) .'/'. self::$controllerPath .'/';
            if(!file_exists($root . $argument .'.php')):
                try {
                    $file = fopen($root . $argument . '.php', 'x+');
                    fwrite($file, '<?php' . PHP_EOL);
                    fwrite($file, PHP_EOL);
                    fwrite($file, "\t");
                    fwrite($file, 'namespace app\controllers;' . PHP_EOL);
                    fwrite($file, "\t");
                    fwrite($file, 'use app\core\Controller;' . PHP_EOL);
                    fwrite($file, "\t");
                    fwrite($file, 'use app\core\Request;' . PHP_EOL);
                    fwrite($file, PHP_EOL);
                    fwrite($file, "\t");
                    fwrite($file, 'class ' . $argument . ' extends Controller {' . PHP_EOL);
                    fwrite($file, "\t\t");
                    fwrite($file, 'public function __construct(){' . PHP_EOL);
                    fwrite($file, "\t\t\t");
                    fwrite($file, '$request = new Request();' . PHP_EOL);
                    fwrite($file, "\t\t");
                    fwrite($file, '}' . PHP_EOL);
                    foreach( self::$controllerDefaultMethods as $key => $value ):
                        $id = '';
                        fwrite($file, PHP_EOL);
                        fwrite($file, "\t\t");
                        fwrite($file, "/*");
                        fwrite($file, PHP_EOL);
                        fwrite($file, "\t\t" . "|--------------------------------------------------------------------------");
                        fwrite($file, PHP_EOL);
                        fwrite($file, "\t\t" . "| ". $key);
                        fwrite($file, PHP_EOL);
                        fwrite($file, "\t\t" . "|--------------------------------------------------------------------------");
                        fwrite($file, PHP_EOL);
                        if ( $value['desc'] == true ) :
                            fwrite($file, "\t\t" . "| ");
                            fwrite($file, PHP_EOL);
                            fwrite($file, "\t\t" . "| ". $value['desc']);
                            fwrite($file, PHP_EOL);
                        endif;
                        fwrite($file, "\t\t" . "| ");
                        fwrite($file, PHP_EOL);
                        fwrite($file, "\t\t");
                        fwrite($file, "*/");
                        fwrite($file, PHP_EOL);
                        fwrite($file, "\t\t");
                        if( $value['id'] == true ):
                            $id = '$id';
                        endif;
                        fwrite($file, 'public function '. $key .'('. $id .') {');
                        fwrite($file, PHP_EOL);
                        if ( $value['params'] == true ):
                            fwrite($file, "\t\t\t");
                            fwrite($file, '$params = [];');
                            fwrite($file, PHP_EOL);
                        endif;
                        if ( $value['return'] == true ):
                            fwrite($file, "\t\t\t");
                            fwrite($file, "return render('". ucwords($key)."'". (($value['params'] == true)
                                    ? ', $params' : null ) .");");
                            fwrite($file, PHP_EOL);
                        endif;
                        fwrite($file, "\t\t");
                        fwrite($file, '}');
                        fwrite($file, PHP_EOL);
                    endforeach;
                    fwrite($file, "\t");
                    fwrite($file, '}' . PHP_EOL);
                    fwrite($file, '?>');
                    fclose($file);
                    return 1;
                } catch(\Exception $e){
                    var_dump($e);
                    return 3;
                }
            else:
                return 2; // file already exits
            endif;
        }

        public static function deleteController(string $argument){
            $root = dirname(__DIR__ ) .'/'. self::$controllerPath .'/';
            $file = $root . $argument .'.php';
            unlink($file);
            return 1;
        }

        public static function createModel(string $argument){
            $root = dirname(__DIR__ ) .'/'. self::$modelPath .'/';
            if(!file_exists($root . $argument .'.php')):
                try {
                    $file = fopen($root . $argument . '.php', 'x+');
                    fwrite($file, '<?php' . PHP_EOL);
                    fwrite($file, PHP_EOL);
                    fwrite($file, "\t");
                    fwrite($file, 'namespace app\models;' . PHP_EOL);
                    fwrite($file, "\t");
                    fwrite($file, 'use app\core\Model;' . PHP_EOL);
                    fwrite($file, "\t");
                    fwrite($file, 'use app\core\Database;' . PHP_EOL);
                    fwrite($file, PHP_EOL);
                    fwrite($file, "\t");
                    fwrite($file, 'class ' . $argument . ' extends Model {' . PHP_EOL);
                    fwrite($file, "\t");
                    fwrite($file, '}' . PHP_EOL);
                    fwrite($file, PHP_EOL);
                    fwrite($file, '?>');
                    fclose($file);
                    return 1;
                } catch(\Exception $e){
                    var_dump($e);
                    return 3;
                }
            else:
                return 2; // file already exits
            endif;
        }
    }