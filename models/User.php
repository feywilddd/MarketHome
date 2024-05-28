<?php
declare(strict_types=1);

namespace models;

class User
{
    public int $id;
    public string $username;
    public string $password;
    public string $restToken;
    public bool $isValid;

    public string $tokenTime;
    public string $RememberMe;
    public string $RememberMeTime;
}