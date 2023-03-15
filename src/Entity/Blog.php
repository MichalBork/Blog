<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'blog')]
class Blog
{

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'text')]
    private string $text;

    #[ORM\Column(type: 'integer')]
    private int $userid;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\User', inversedBy: 'blogs')]
    #[ORM\JoinColumn(name: 'userid', referencedColumnName: 'userid')]
    private $user;

    public function __construct(string $text, User $user)
    {
        $this->text = $text;
        $this->user = $user;
        $this->userid = $user->getUserid();
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getId(): int
    {
        return $this->id;
    }
}