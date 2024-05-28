<?php
declare(strict_types=1);

namespace repositories;

class BaseRepository
{
    public \PDO $bd;

    function __construct()
    {
        $this->bd = new \PDO('mysql:dbname=TP-1;host=host.docker.internal', 'root', 'root');
    }
}