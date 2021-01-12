<?php

namespace App\Model;


use App\Utils\Config;
use PDO;
use PDOException;

abstract class Model
{
    public static function findAll(string $table): array
    {
        $db = self::getDb();
        $stm = $db->query("SELECT * FROM  $table");
        $result = $stm->fetchAll(\PDO::FETCH_ASSOC);
        return $result ? : [];
    }

    public static function findById(string $table, int $id): array
    {
        $db = self::getDb();
        $stm = $db->prepare("SELECT * FROM $table WHERE `id` = ?");
        $stm->execute([$id]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);
        return $result ? : [];
    }

    public static function remove(string $table, int $id): void
    {
        $db = self::getDb();
        $stm = $db->prepare("DELETE FROM $table WHERE `id` = ?");
        $stm->execute([$id]);
    }

    protected static function getDb()
    {
        try {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s',
                Config::get('DB_HOST'),
                Config::get('DB_NAME')
            );
            $pdo = new PDO($dsn, Config::get('DB_USER'), Config::get('DB_PASS'));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            exit('Connection to database failed');
        }
        return $pdo;
    }
}