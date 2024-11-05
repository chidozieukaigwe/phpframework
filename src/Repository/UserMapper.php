<?php
namespace App\Repository;

use App\Entity\User;
use ChidoUkaigwe\Framework\Dbal\DataMapper;
use Doctrine\DBAL\Connection;

class UserMapper
{

    public function __construct(private DataMapper $dataMapper)
    {
        
    }

    public function save(User $user)
    {
        $stmt = $this->dataMapper->getConnection()->prepare("INSERT INTO users (username, password, created_at) VALUES (:username, :password, :created_at)
        ");

        $stmt->bindValue('username', $user->getUsername());
        $stmt->bindValue('password', $user->getPassword());
        $stmt->bindValue('created_at', $user->getCreatedAt()->format('Y-m-d H:i:s'));

        $stmt->executeStatement();

        $id = $this->dataMapper->save($user);

        $user->setId($id);
    }

}