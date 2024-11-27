<?php

namespace App\Repository;

use App\Entity\Evenement;
use App\Entity\Salle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;


/**
 * @extends ServiceEntityRepository<Evenement>
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    /**
     * Vérifie si une salle est disponible pour une date et un créneau horaire.
     *
     * @param Salle $salle
     * @param \DateTimeInterface $date
     * @param \DateTimeInterface $heureDebut
     * @param \DateTimeInterface $heureFin
     * @return array Retourne un tableau d'événements conflictuels (vide si aucun conflit).
     */
    public function checkAvailability(Salle $salle, \DateTimeInterface $date, \DateTimeInterface $heureDebut, \DateTimeInterface $heureFin): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.salle = :salle')
            ->andWhere('e.date = :date')
            ->andWhere('e.heureDebut < :heureFin AND e.heureFin > :heureDebut')
            ->setParameter('salle', $salle)
            ->setParameter('date', $date)
            ->setParameter('heureDebut', $heureDebut)
            ->setParameter('heureFin', $heureFin)
            ->getQuery()
            ->getResult();
    }
    

    /**
     * Récupère les salles disponibles pour une date et un créneau horaire.
     *
     * @param \DateTimeInterface $date
     * @param \DateTimeInterface $heureDebut
     * @param \DateTimeInterface $heureFin
     * @return array Retourne un tableau de salles disponibles.
     */
    public function findAvailableSalles(\DateTimeInterface $date, \DateTimeInterface $heureDebut, \DateTimeInterface $heureFin): array
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT s
                FROM App\Entity\Salle s
                WHERE NOT EXISTS (
                    SELECT 1
                    FROM App\Entity\Evenement e
                    WHERE e.salle = s
                    AND e.date = :date
                    AND e.heureDebut < :heureFin AND e.heureFin > :heureDebut
                )'
            )
            ->setParameters([
                'date' => $date,
                'heureDebut' => $heureDebut,
                'heureFin' => $heureFin,
            ])
            ->getResult();
    }
}
