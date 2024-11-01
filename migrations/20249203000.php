<?php

return new class
{

    public function up(): void
    {
        echo get_class($this) . '::up() called'. PHP_EOL;
    }

    public function down(): void
    {
        echo get_class($this) . '::down() called'. PHP_EOL;
    }

};