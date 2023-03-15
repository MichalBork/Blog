<?php

namespace App\Command;

class RegisterUserCommand
{


    private string $userName;
    private string $password;
    private string $permission;
    private string $readonly;

    public function __construct(string $userName, string $password, string $permission, string $readonly)
    {
        $this->userName = $userName;
        $this->password = $password;
        $this->permission = $permission;
        $this->readonly = $readonly;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getPermission(): string
    {
        return $this->permission;
    }

    /**
     * @return string
     */
    public function isReadonly(): string
    {
        return $this->readonly;
    }


}