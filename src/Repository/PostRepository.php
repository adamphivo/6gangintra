<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function getAll() {
        return $this->createQueryBuilder('p')
        ->orderBy('p.dateAdded', 'DESC')
        ->getQuery()
        ->getResult();
    }

    public function getById(int $id) {
        return $this->createQueryBuilder('p')
        ->where('p.id = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getSingleResult();
    }

    public function getLasts(int $limit) {
        return $this->createQueryBuilder('p')
        ->orderBy('p.dateAdded', 'DESC')
        ->getQuery()
        ->setMaxResults($limit)
        ->getResult();
    }

    public function getOneRandomly(): ?Post
    {
        $all = $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult()
        ;
        return $all[rand(0,count($all) - 1)];
    }
}
