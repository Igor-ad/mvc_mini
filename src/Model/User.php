<?php

namespace App\Model;


class User extends Model
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public function save(array $data): array
    {
        $search = $this->checkEmail($data);
        if (!empty($search)) {
                return $this->alertMsg($search['email']);
        } else {
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
            return [];
        }
    }

    public function update(array $data): array
    {
        $search = $this->checkEmail($data);
        if (!empty($search) && ($data['id'] != $search['id'])) {
            return $this->alertMsg($search['email']);
        } else {
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
        return [];
    }

    public function checkEmail(array $data): array
    {
        $search = ($this->findBy(['email' => $data['email']]))
            ? $this->findBy(['email' => $data['email']]) : [];

        return $search;
    }

    public function alertMsg($email): array
    {
        $msg[] = 'Email must be different than ' . $email;
        return ['email' => $msg];
    }
}