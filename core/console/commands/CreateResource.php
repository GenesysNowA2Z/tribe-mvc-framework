<?php

    namespace app\core\console\commands;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use app\core\console;

    class CreateResource extends Command {

        protected $command = 'create:resource';
        protected $description = 'Creates a controller with all the methods of a resource';
        protected $argument = 'resourceName';
        protected $argumentDesc = 'The name of the controller to be created';
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
            if($this->check($input->getArgument($this->argument))){
                $response = 'A resource with the name "'. $this->argument .'" already exists!';
                $output->writeln('<error>'. $response. '</error>');
            } else {
                $execute = \app\core\Console::createResource($input->getArgument($this->argument));
                if ($execute == 1) :
                    $response = '"'. $input->getArgument($this->argument) .'" was successfully created!';
                    $output->writeln('<info>'. $response. '</info>');
                else:
                    $response = '"'. $input->getArgument($this->argument) .'" already exists!';
                    $output->writeln('<comment>'. $response. '</comment>');
                endif;
            }
            return 0;
        }

        protected function check($argument) {
            $file = dirname(
                        dirname(
                            dirname(__DIR__ ))) .'/'. $this->actionPath .'/'. $argument . '.php';
            if (file_exists($file)) {
                return true;
            }
            return false;
        }
    }