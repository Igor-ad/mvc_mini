<?php

namespace App\Model;


class Ads extends Model
{
    public const LENGTH_TITLE_MAX = 100;
    public const LENGTH_BODY_MAX = 1000;
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public function save($data): void
    {
        $db = $this->getDb();
        $stm = $db->prepare('
            INSERT INTO ' . $this->table . ' (`title`, `body`, `status`, `created_at`)
            VALUE (?,?,?,now())
        ');

        $stm->execute([
            $data['title'],
            $data['body'],
            self::STATUS_ACTIVE
        ]);
    }

    public function update($data): void
    {
        $db = $this->getDb();
        $stm = $db->prepare('
            UPDATE ' . $this->table . '
            SET `title` = ?, `body` = ?, `status` = ? 
            WHERE `id` = ?
        ');

        $stm->execute([
            $data['title'],
            $data['body'],
            $data['status'],
            $data['id']
        ]);
    }
}