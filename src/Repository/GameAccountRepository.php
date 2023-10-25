<?php

namespace App\Repository;

use App\Entity\GameAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GameAccount>
 *
 * @method GameAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameAccount[]    findAll()
 * @method GameAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameAccount::class);
    }

//    /**
//     * @return GameAccount[] Returns an array of GameAccount objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GameAccount
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
