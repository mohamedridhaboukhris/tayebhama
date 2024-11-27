<?php

namespace App\Repository;

use App\Entity\Salle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Salle>
 */
class SalleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salle::class);
    }

    public function findByCriteria(array $criteria): array
    {
        $qb = $this->createQueryBuilder('s');

        if (!empty($criteria['id'])) {
            $qb->andWhere('s.id = :id')->setParameter('id', $criteria['id']);
        }

        if (!empty($criteria['bloc'])) {
            $qb->andWhere('s.bloc = :bloc')->setParameter('bloc', $criteria['bloc']);
        }

        if (!empty($criteria['capacite'])) {
            $qb->andWhere('s.capacite >= :capacite')->setParameter('capacite', $criteria['capacite']);
        }

        return $qb->getQuery()->getResult();
    }
}
