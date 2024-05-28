<?php
declare(strict_types=1);

namespace repositories;

use \models\User;

class UserRepository extends BaseRepository
{

    function searchUser(User $user): array
    {
        $query = $this->bd->prepare('SELECT * FROM users WHERE username = :username');
        $query->bindValue(':username', $user->username, \PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, \models\User::class);
    }

    function createUser(User $user): void
    {
        $query = $this->bd->prepare('INSERT INTO users (username, password,restToken,tokenTime) VALUES (:username, :password, :token, :expire)');
        $query->bindValue(':username', $user->username, \PDO::PARAM_STR);
        $query->bindValue(':password', $user->password, \PDO::PARAM_STR);
        $query->bindValue(':token', $user->restToken, \PDO::PARAM_STR);
        $query->bindValue(':expire', $user->tokenTime, \PDO::PARAM_STR);
        $query->execute();
    }

    function updatePassword(int $userId, string $newPassword): void
    {
        $query = $this->bd->prepare('UPDATE users SET password = :password WHERE id = :id');
        $query->bindValue(':id', $userId, \PDO::PARAM_INT);
        $query->bindValue(':password', $newPassword, \PDO::PARAM_STR);
        $query->execute();
    }

    function addToken(User $user, string $token): void
    {
        $query = $this->bd->prepare('UPDATE users SET restToken = :token WHERE id = :id');
        $query->bindValue(':id', $user->id, \PDO::PARAM_INT);
        $query->bindValue(':token', $token, \PDO::PARAM_STR);
        $query->execute();
    }

    function getUserByToken(string $token): array
    {
        $query = $this->bd->prepare('SELECT * FROM users WHERE restToken = :token');
        $query->bindValue(':token', $token, \PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, \models\User::class);
    }

    function setTokenTime(User $user): void
    {
        $query = $this->bd->prepare('UPDATE users SET tokenTime = :time WHERE id = :id');
        $query->bindValue(':id', $user->id, \PDO::PARAM_INT);
        $query->bindValue(':time', $user->tokenTime, \PDO::PARAM_INT);
        $query->execute();
    }

    function setValid(User $user): void
    {
        $query = $this->bd->prepare('UPDATE users SET isValid = TRUE WHERE id = :id');
        $query->bindValue(':id', $user->id, \PDO::PARAM_INT);
        $query->execute();
    }

    function getUserByRememberMe(string $token): array
    {
        $query = $this->bd->prepare('SELECT * FROM users WHERE RememberMe = :token');
        $query->bindValue(':token', $token, \PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, \models\User::class);
    }

    function setRememberMe(User $user, string $token): void
    {
        $query = $this->bd->prepare('UPDATE users SET RememberMe = :token, RememberMeTime = :time WHERE id = :id');
        $query->bindValue(':id', $user->id, \PDO::PARAM_INT);
        $query->bindValue(':time', $user->RememberMeTime, \PDO::PARAM_INT);
        $query->bindValue(':token', $token, \PDO::PARAM_STR);
        $query->execute();
    }
}