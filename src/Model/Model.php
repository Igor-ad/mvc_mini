<?php

namespace App\Model;


use App\Utils\Config;
use PDO;
use PDOException;


abstract class Model
{
    protected static PDO $db;
    protected string $table;

    public function __construct(string $table)
    {
        $this->table = $table;
        self::$db = $this->getDb();
    }

    public function findAll(): array
    {
        $stm = $this->getDb()->query('SELECT * FROM ' . $this->table);
        return $stm->fetchAll(PDO::FETCH_ASSOC) ? : [];
    }

    public function findById(int $id): array
    {
        $sql = sprintf('SELECT * FROM %s WHERE `id` = ?', $this->table);
        $stm = $this->getDb()->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);
        return $result ? : [];
    }

    public function findBy(array  $data): array
    {
        $placeholders = $this->getKeyStr($data);
        $sql = sprintf('SELECT * FROM %s WHERE' . $placeholders, $this->table);
        $stm = $this->getDb()->prepare($sql);
        $stm->execute([implode(',', $data)]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);
        return $result ? : [];
    }

    public function keyStr($key): string
    {
        $str = ' `' . $key . '` = ?';
        return $str;
    }

    public function getKeyStr(array $data): string
    {
        $keyArray = array_keys($data);
        $sqlParamStr = array_map(array($this, 'keyStr'), $keyArray);
        return implode(' AND ', $sqlParamStr);
    }

    public function remove(int $id): void
    {
        $sql = sprintf('DELETE FROM %s WHERE `id` = ?', $this->table);
        $stm = $this->getDb()->prepare($sql);
        $stm->execute([$id]);
    }

    public function getDb(): PDO
    {
        if (!isset(self::$db)) {
            try {
                $dsn = sprintf(
                    'mysql:host=%s;dbname=%s',
                    Config::get('DB_HOST'),
                    Config::get('DB_NAME')
                );
                self::$db = new PDO($dsn, Config::get('DB_USER'), Config::get('DB_PASS'));
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                exit('Connection to database failed');
            }
        }
        return self::$db;
    }
}