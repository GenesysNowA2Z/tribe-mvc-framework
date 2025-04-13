<?php

    namespace app\core\console\commands;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    class DeleteController extends Command {

        protected $command = 'delete:controller';
        protected $description = 'Delete a controller with the specified name';
        protected $argument = 'name';
        protected $argumentDesc = 'The name of the controller to be deleted';
        protected $actionPath = 'controllers';

        public function __construct() {
            parent::__construct();
        }

        protected function configure() {
            $this->setName($this->command)
                 ->setDescription($this->description)
                 ->addArgument(
                    $this->argument,
                    InputArgument::REQUIRED,
                    $this->argumentDesc
                );
        }

        protected function execute(InputInterface $input, OutputInterface $output) : int {
            if($this->check($input->getArgument($this->argument)) == false){
                $response = '"'. $input->getArgument($this->argument) .'" does not exists!';
                $output->writeln('<error>'. $response. '</error>');
            } else {
                $execute = \app\core\Console::deleteController($input->getArgument($this->argument));
                $response = '"'. $input->getArgument($this->argument) .'" was successfully deleted!';
                $output->writeln('<info>'. $response. '</info>');
            }
            return 0;
        }

        protected function check($argument) {
            $file = dirname(
                        dirname(
                            dirname(__DIR__ ))) .'/'. $this->actionPath .'/'. $argument . '.php';
            echo $file;
            if (file_exists($file)) {
                return true;
            }
            return false;
        }

    }