<?php

namespace App\Repository;

use App\Entity\Token;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


class TokenRepository extends ServiceEntityRepository
{
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
        parent::__construct($managerRegistry, Token::class);


    }

    public function save(Token $token)
    {
        $entity = $this->getEntityManager();
        $entity->persist($token);
        $entity->flush();
    }

}