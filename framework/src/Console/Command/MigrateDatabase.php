<?php

namespace ChidoUkaigwe\Framework\Console\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

class MigrateDatabase implements CommandInterface
{
    private string $name = 'database:migrations:migrate';

    public function __construct(private Connection $connection) {}

    public function execute(array $params = []): int
    {

        try {
            
        //  Create a mingration table SQL if table not already exists
        $this->createMigrationsTable();

        $this->connection->beginTransaction();
        //  Get $appliedMigrations which are already in the database.migrations table
            $appliedMigrations = $this->getAppliedMigrations();
            
        //  Get the migration files from migration folder

        // Get the migrations to apply. i.e there are in $migratonsFiles but not in $appliedMigrations

        // Create SQL for any migrations which have not been run ... i.e which are not in the database

        // Add migration to database

        //  Execute the SQL query

        $this->connection->commit();

        return 0;

        } catch (\Throwable $th) {
            $this->connection->rollBack();
            echo "Error migrating the database: ". $th->getMessage(). "\n";
           throw $th;
        }

    }

    private function createMigrationsTable(): void
    {
        $schemaManager = $this->connection->createSchemaManager();

        if (!$schemaManager->tablesExist('migrations')) {
            $schema = new Schema();
            $table = $schema->createTable('migrations');
            $table->addColumn('id', Types::INTEGER, ['unsigned' => true, 'autoincrement' => true]);
            $table->addColumn('migration', Types::STRING, ['length' => 255]);
            $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['default' => 'CURRENT_TIMESTAMP']);
            $table->setPrimaryKey(['id']);

            $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());

            $this->connection->executeQuery($sqlArray[0]);

            echo "Migrations table created successfully.\n";
        }
    }

    private function getAppliedMigrations()
    {
        $sql = "SELECT migration FROM migrations";

        $appliedMigrations = $this->connection->executeQuery($sql)->fetchFirstColumn();
        return $appliedMigrations;
    }
}
