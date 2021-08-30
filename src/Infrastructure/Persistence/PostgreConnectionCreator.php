<?php

namespace SoftExpert\Market\Infrastructure\Persistence;

use PDO;

class PostgreConnectionCreator
{
    public static function createConnection(): ?PDO
    {
        $connection = new PDO(
            'pgsql:host=172.28.1.2;port=5432;dbname=softexpert',
            'gleidson',
            'softexpert@123456'
        );
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        if ($connection->connect_error) {
            die("Falha na conexão: " . $connection->errorInfo);
        }

        return $connection;
    }
}
