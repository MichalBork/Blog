<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RegisterUserCommandHandler
{
    private UserRepository $userRepository;
    private UserService $userService;

    public function __construct(UserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        $user = new User(
            $command->getUserName(),
            $this->userService->hashPassword($command->getPassword()),
            $command->getPermission(),
            $command->isReadonly()
        );


        $this->userRepository->save($user);
    }

}