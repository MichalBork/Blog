<?php

namespace App\Command;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class NewBlogCommand
{
    private string $text;
    private string $userToken;

    public function __construct(string $text, string $userToken)
    {
        $this->text = $text;
        $this->userToken = $userToken;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getUserToken(): UuidInterface
    {
        return Uuid::fromString($this->userToken);
    }


}