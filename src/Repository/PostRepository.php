<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }
    
    /**
     * @param string $title
     * @param string $content
     * @param string $draft
     * @return Post
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(string $title, string $content, string $draft): Post
    {
        $subject = new Post();
        $subject->setTitle("test");
        $subject->setContent("content");
        $subject->setCurrentPlace('draft');
    
        $this->getEntityManager()->persist($subject);
        $this->getEntityManager()->flush();
        
        return $subject;
    }
    
    /**
     * @param Post|null $subject
     * @param string    $place
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updatePlaces(?Post $subject, string $place)
    {
        $subject->setCurrentPlace($place);
        $this->getEntityManager()->persist($subject);
        $this->getEntityManager()->flush();
    }
    
    /**
     * @param $id
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function resetPlace($id)
    {
        $subject = $this->find($id);
        $subject->setCurrentPlace('draft');
        $this->getEntityManager()->persist($subject);
        $this->getEntityManager()->flush();
    }
    
    // /**
    //  * @return Post[] Returns an array of Post objects
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
    public function findOneBySomeField($value): ?Post
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
