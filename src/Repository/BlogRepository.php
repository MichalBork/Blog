<?php

namespace App\Repository;

use App\Entity\Blog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
        parent::__construct($managerRegistry, Blog::class);
    }


    public function save(Blog $blog)
    {
        $entity = $this->getEntityManager();
        $entity->persist($blog);
        $entity->flush();
    }

    public function remove(Blog $blog): void
    {
        $entity = $this->getEntityManager();
        $entity->remove($blog);
        $entity->flush();

    }


}