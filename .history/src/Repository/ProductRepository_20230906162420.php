<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
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

    public function findProductsType(string $productType)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.type = :productType')
            ->setParameter('productType', $productType)
            ->orderBy('p.category')
            ->getQuery()
            ->getResult();
    }
}
