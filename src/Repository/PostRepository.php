<?php
namespace App\Repository;

use App\Entity\Post;
use ChidoUkaigwe\Framework\Http\Exception\NotFoundException;
use Doctrine\DBAL\Connection;

class PostRepository
{
    public function __construct(
        private Connection $connection,
    )
    {}

    public function findById(int $id): ?Post
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('id', 'title', 'body', 'created_at')
            ->from('posts')
            ->where('id = :id')
            ->setParameter('id', $id);

        $result = $queryBuilder->executeQuery();

        $row = $result->fetchAssociative();

        if (!$row) {
            return null;
        }

        $post = Post::create(
            id: $row['id'],
            title: $row['title'],
            body: $row['body'],
            createdAt: new \DateTimeImmutable($row['created_at'])
        );

        return $post;

    }

    public function findOrFail(int $id): Post
    {
        $post = $this->findById($id);

        if (!$post) {
            throw new NotFoundException("Post not found with id: $id");
        }

        return $post;
    }
}