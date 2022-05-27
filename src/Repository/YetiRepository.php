<?php

namespace App\Repository;

use App\Entity\Yeti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @extends ServiceEntityRepository<Yeti>
 *
 * @method Yeti|null find($id, $lockMode = null, $lockVersion = null)
 * @method Yeti|null findOneBy(array $criteria, array $orderBy = null)
 * @method Yeti[]    findAll()
 * @method Yeti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YetiRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Yeti::class);
    }

    public function add(Yeti $entity, bool $flush = false): void {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Yeti $entity, bool $flush = false): void {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getTopTen() {
        $qb = $this->createQueryBuilder('yeti');

        $qb
            ->select('yeti')
            ->orderBy('yeti.rating', 'DESC')
            ->setMaxResults(10);

        return $qb->getQuery()->getResult();
    }

    public function getRandom(){
        $qb = $this->createQueryBuilder('yeti');
//        $qb
//            ->select('yeti')
//            ->orderBy('RAND()')
//            ->setMaxResults(1);

        $rsm = new ResultSetMapping();


        $query = $this->getEntityManager()->createNativeQuery('SELECT * FROM yeti WHERE RAND()<(SELECT ((1/COUNT(*))*10) FROM yeti) ORDER BY RAND() LIMIT 1', $rsm);
        $query->setParameter('id', '1');
        // "SELECT * FROM yeti WHERE RAND()<(SELECT ((1/COUNT(*))*10) FROM yeti) ORDER BY RAND() LIMIT 1" random select
        return $query->getResult();
//        return $qb->getQuery()->getOneOrNullResult();
    }

//    /**
//     * @return Yeti[] Returns an array of Yeti objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Yeti
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
