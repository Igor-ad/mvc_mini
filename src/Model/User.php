<?php

namespace App\Model;


class User extends Model
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public function save($data): void
    {
        $db = $this->getDb();
        $stm = $db->prepare('
            INSERT INTO ' . $this->table . ' (`name`, `email`, `password`, `status`, `created_at`)
            VALUE (?,?,?,?,now())
        ');

        $stm->execute([
            $data['name'],
            $data['email'],
            $data['password'],
            self::STATUS_ACTIVE
        ]);
    }

    public function update($data): void
    {
        $db = $this->getDb();
        $stm = $db->prepare('
            UPDATE ' . $this->table . '
            SET `name` = ?, `email` = ?, `password` = ?, `status` = ?
            WHERE `id` = ?
        ');

        $stm->execute([
            $data['name'],
            $data['email'],
            $data['password'],
            $data['status'],
            $data['id']
        ]);
    }
}