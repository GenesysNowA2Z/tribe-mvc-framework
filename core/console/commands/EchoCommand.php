<?php

    namespace app\core\console\commands;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    class EchoCommand extends Command {
        protected static $commandName = 'command:echo';
        protected static $commandDescription = 'Responds with Hello to let the sender know that they are alive.';

        protected $commandArgumentName = "name";
        protected $commandArgumentDescription = "Who do you want to greet?";

        public function __construct() {
            parent::__construct();
        }

        protected function configure()
        {
            $this
                ->setName(self::$commandName)
                ->setDescription(self::$commandDescription)
                ->addArgument(
                    $this->commandArgumentName,
                    InputArgument::OPTIONAL,
                    $this->commandArgumentDescription
                )

            ;
        }

        protected function execute(InputInterface $input, OutputInterface $output): int
        {
            $name = $input->getArgument($this->commandArgumentName);
            if ($name) {
                $text = 'Hello '.$name;
            } else {
                $text = 'Hello';
            }
//            if ($input->getOption($this->commandOptionName)) {
//                $text = strtoupper($text);
//            }

//            $text = 'Hello';
            $output->writeln($text);
            return 0;
        }

    }