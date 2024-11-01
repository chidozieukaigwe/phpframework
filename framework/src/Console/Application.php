<?php
namespace ChidoUkaigwe\Framework\Console;

use Psr\Container\ContainerInterface;

class Application
{
    public function __construct(private ContainerInterface $container)
    {

    }


    public function run(): int
    {
        // use environment variables to obtain the command name 
        $argv = $_SERVER['argv'];

        $commandName = $argv[1]?? null;
        //  throw an exception if the command name is not provided

        if (!$commandName) {
            throw new ConsoleException('A command name must be provided.');
        }

        //  use the command name to find the corresponding command class in the container

        $command = $this->container->get($commandName);

        //  parse variables to obtain options and arguments
        $args = array_slice($argv, 2);

        $options = $this->parseOptions($args);
        //  Execute the command, returning the status code

        $status = $command->execute($options);

        // return status code

        return $status;
    }

    private function parseOptions(array $args): array
    {
        $options = [];

        //  loop through the arguments and extract options
        foreach ($args as $arg) {
            if (str_starts_with($arg, '--' )) {
                // This is an option
               $option = explode('=', substr($arg, 2));
               $options[$option[0]] = $option[1]?? true;
            }
        }
     return $options;
    }
}