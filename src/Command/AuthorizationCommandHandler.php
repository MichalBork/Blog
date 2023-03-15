<?php

namespace App\Command;

use App\Repository\TokenRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class AuthorizationCommandHandler
{

    private TokenRepository $tokenRepository;

    public function __construct(TokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function __invoke(AuthorizationCommand $command): void
    {
        try {
            $token = $this->tokenRepository->findOneBy(['id' => $command->getToken()]);


        }catch (\Throwable $e){
            throw new \Exception('User not found invalid token');
        }

        if (is_null($token)) {
            throw new \Exception('User not found invalid token');
        }


        if ($this->checkPermission(
                $command->getPermission(),
                $token->getUser()->getPermission()
            )) {
            throw new \Exception('Invalid permission');
        }
    }

    private function requirePermission(?string $permission): bool
    {
        return is_null($permission);
    }

    private function checkPermission(?string $requiredPermission, string $givenPermission): bool
    {
        if ($this->requirePermission($requiredPermission)) {
            return false;
        }
        return $requiredPermission !== $givenPermission;
    }

}