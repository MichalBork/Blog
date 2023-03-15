<?php

namespace App\Service;


use App\Entity\Token;
use App\Entity\User;
use App\Repository\TokenRepository;
use Ramsey\Uuid\UuidInterface;

class UserService implements UserInterface
{

    private TokenRepository $tokenRepository;

    public function __construct(TokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function generateToken(User $user): Token
    {
        $user->getToken()->setToken();
        return $user->getToken();
    }


}