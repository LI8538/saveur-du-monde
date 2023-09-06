<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }


    public function findProductsByCategoryAndType(string $categoryName, string $productType)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.category', 'c')
            ->andWhere('c.name = :categoryName')
            ->setParameter('categoryName', $categoryName)
            ->andWhere('p.type = :productType')
            ->setParameter('productType', $productType)
            ->getQuery()
            ->getResult();
    }

    public function findProductsByType(string $productType)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.type = :productType')
            ->setParameter('productType', $productType)
            ->orderBy('p.category')
            ->getQuery()
            ->getResult();
    }
}
