<?php

namespace App\Command;

use App\Entity\Token;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use App\Service\UserService;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class LoginCommandHandle
{

    private UserRepository $userRepository;
    private UserService $userService;
    private tokenRepository $tokenRepository;

    public function __construct(
        UserRepository $userRepository,
        UserService $userService,
        tokenRepository $tokenRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->tokenRepository = $tokenRepository;
    }

    public function __invoke(LoginCommand $command): UuidInterface
    {
        $user = $this->userRepository->findOneBy(['username' => $command->getUserName()]);

        if ($user === null) {
            throw new \Exception('User not found');
        }

        if (!$this->userService->verifyPassword($command->getPassword(), $user->getPassword())) {
            throw new \Exception('Invalid password');
        }

        $token = $this->userService->generateToken($user);
        $this->tokenRepository->save($token);

        return $token->getId();
    }

}