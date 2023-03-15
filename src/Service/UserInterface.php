<?php

namespace App\Service;

interface UserInterface
{
    public function hashPassword(string $password): string;

    public function verifyPassword(string $password, string $hash): bool;

}