<?php
namespace ChidoUkaigwe\Framework\Console;

use ChidoUkaigwe\Framework\Console\Command\CommandInterface;
use Psr\Container\ContainerInterface;
use ReflectionClass;

class Kernel
{
    public function __construct(
        private ContainerInterface $container,
        private Application $application)
    {}

    public function handle(): int
    {
        // Register commands with the container
        $this->registerCommands();
        //  Run the console application, returning a status code
        $status = $this->application->run();
        //  return the status code
        return 0;
    }

    private function registerCommands(): void
    {   
        // === Register All Built in commands ===
        // get all files in the commands dir
        $comandFiles = new \DirectoryIterator(__DIR__. '/Command');

        $namespace = $this->container->get('base-commands-namespace');

        //  Loop over all files in the commands folder
        foreach ($comandFiles as $commandFile) {

            if (!$commandFile->isFile()){
                continue;
            }

            // get the command class using psr4 this will be same as filename
            $command = $namespace.pathinfo($commandFile, PATHINFO_FILENAME);

            //  if it is a subclass of Command Interface
           if(is_subclass_of($command, CommandInterface::class)) {
                 //  add it to the container, using the name as the ID e.g. $container->add('database:migrations:migrate', MigrateDatabase::class);
                 $commandName = (new ReflectionClass($command))->getProperty('name')->getDefaultValue();

                 $this->container->add($commandName, $command);

           }

        }
       
        

        

   

    }
}