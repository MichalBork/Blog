<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'user')]
class User
{


    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $userid;

    #[ORM\Column(type: 'string')]
    private string $username;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'string')]
    private string $permission;

    #[ORM\Column(type: 'string')]
    private string $readonly;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: 'App\Entity\Token',cascade: [
        'persist',
        'remove'
    ])]
    private Token $token;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: 'App\Entity\Blog')]
    private Collection $blogs;

    public function __construct(string $username, string $password, string $permission, string $readonly)
    {
        $this->username = $username;
        $this->password = $password;
        $this->permission = $permission;
        $this->readonly = $readonly;
        $this->token = new Token($this);
    }


    public function getUserid(): int
    {
        return $this->userid;
    }


    public function getUsername(): string
    {
        return $this->username;
    }


    public function getPassword(): string
    {
        return $this->password;
    }


    public function getPermission(): string
    {
        return $this->permission;
    }


    public function getReadonly(): string
    {
        return $this->readonly;
    }

    /**
     * @return mixed
     */
    public function getBlogs(): ArrayCollection
    {
        return $this->blogs;
    }

    public function getToken(): Token
    {
        return $this->token;
    }


}