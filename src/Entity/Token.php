<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'token')]
class Token
{

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private UuidInterface $id;

    #[ORM\OneToOne(inversedBy: 'token', targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'userid', referencedColumnName: 'userid')]
    private User $user;

    public function __construct(User $user)
    {
        $this->id = Uuid::uuid4();
        $this->user = $user;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setToken(): void
    {
        $this->id = Uuid::uuid4();
    }

    public function getUser(): User
    {
        return $this->user;
    }

}