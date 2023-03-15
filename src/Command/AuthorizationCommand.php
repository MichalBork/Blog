<?php

namespace App\Command;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AuthorizationCommand
{

    private string $token;
    private ?string $permission;

    public function __construct(string $token, ?string $permission=null)
    {
        $this->token = $token;
        $this->permission = $permission;
    }

    public function getToken(): UuidInterface
    {
        return Uuid::fromString($this->token);
    }

    public function getPermission(): ?string
    {
        return $this->permission;
    }
}