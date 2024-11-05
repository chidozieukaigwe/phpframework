<?php 
namespace ChidoUkaigwe\Framework\Dbal;

use ChidoUkaigwe\Framework\Dbal\Event\PostPersist;
use ChidoUkaigwe\Framework\EventDispatcher\EventDispatcher;
use Doctrine\DBAL\Connection;

class DataMapper
{
    public function __construct(private Connection $connection, private EventDispatcher $eventDispatcher)
    {
        
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function save(Entity $subject): int|string|null
    {
        //  Dispatch PostPersist event
        $this->eventDispatcher->dispatch(new PostPersist($subject));
        //  return lastInsertId
        return $this->connection->lastInsertId();
    }
}