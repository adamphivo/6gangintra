<?php

namespace App\Repository;

use App\Entity\ExperienceEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExperienceEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExperienceEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExperienceEvent[]    findAll()
 * @method ExperienceEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExperienceEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExperienceEvent::class);
    }

    public function getLastActivities()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.madeAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
}
