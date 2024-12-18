<?php

namespace App\Service;

use PDO;
use PDOException;

class UtilDB
{
    private string $dsn;
    private string $userName;
    private string $password;

    public function __construct(string $dsn, string $userName, string $password)
    {
        $this->dsn = $dsn;
        $this->userName = $userName;
        $this->password = $password;
    }

    public function getConnection(): ?PDO
    {
        try {
            $pdo = new PDO($this->dsn, $this->userName, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            throw new \Exception('Database connection failed: ' . $e->getMessage());
        }
    }
}

