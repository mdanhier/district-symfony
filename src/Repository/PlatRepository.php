<?php

namespace App\Repository;

use App\Entity\Plat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Plat>
 *
 * @method Plat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plat[]    findAll()
 * @method Plat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plat::class);
    }

    public function save(Plat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Plat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findMostPopularPlats(): array
    {
        $qb = $this->createQueryBuilder('p')
            ->join('p.details', 'd')
            ->select('p, COUNT(d.commande) AS total')
            ->where('p.active = 1')
            ->groupBy('p')
            ->orderBy('total', 'DESC')
            ->addOrderBy('p.libelle', 'ASC')
            ->setMaxResults(4);

        $query = $qb->getQuery();
        return $query->execute();
    }

    public function searchPlat($search): array
    {
        $search = '%'.$search.'%';
        $qb = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.active = 1')
            ->andWhere('p.libelle LIKE :search')
            ->orderBy('p.libelle')
            ->setParameter('search', $search);
        $query = $qb->getQuery();
        return $query->execute();
    }

    public function countPlats($categorieId): int
    {
        $qb = $this->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->where('p.categorie = :categorieId')
            ->setParameter('categorieId', $categorieId);
        $query = $qb->getQuery();
        return $query->getSingleScalarResult();
    }

    //    /**
    //     * @return Plat[] Returns an array of Plat objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Plat
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
