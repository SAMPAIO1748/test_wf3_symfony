<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function searchByTerm($term)
    {
        // Création du queryBuilder qui va permettre de faire la requête SQL
        $queryBuilder = $this->createQueryBuilder("article");
        $query = $queryBuilder
            ->select('article') // On fait le select
            ->leftJoin('article.category', 'category') // on fait un leftjoin
            ->leftJoin('article.tag', 'tag')
            ->where('article.title LIKE :term') // on fait un where
            ->orWhere('article.content LIKE :term') // on fait un OR WHERE
            ->orWhere('category.name LIKE :term')
            ->orWhere('category.description LIKE :term')
            ->orWhere('tag.name LIKE :term')
            ->orWhere('tag.description LIKE :term')
            ->orWhere('tag.color LIKE :term')
            ->setParameter('term', '%' . $term . "%") // on paramètre le contenu de term et on sécurise la requête
            ->getQuery(); // on récupère la requête

        return $query->getResult(); // On récupère le résultat
    }

    public function add(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Article[] Returns an array of Article objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Article
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
