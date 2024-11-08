<?php

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

return new class
{

    public function up(Schema $schema): void
    {
        echo get_class($this) . '::up() called'. PHP_EOL;
    }

    public function down(): void
    {
        echo get_class($this) . '::down() called'. PHP_EOL;
    }

};