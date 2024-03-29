<?php

namespace App\Repository;

use App\Entity\Product;
use App\Extensions\Doctrine\MatchAgainst;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

public function search($mots = null, $categorie = null){
       $query = $this->createQueryBuilder('p');
       $query->where('p.active = 1');
       if($mots != null) {
           $query->andWhere('MatchAgainst(product.title ,product.description) AGAINST(:mots boolean>0)')
        ->setParameter('mots', $mots);

           
       }
    if($categorie != null){
            $query->leftJoin('p.categories', 'c');
            $query->andWhere('c.id = :id')
                ->setParameter('id', $categorie);
    }

return $query->getQuery()->getResult();

   }


    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
