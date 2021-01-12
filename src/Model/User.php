<?php

namespace App\Model;

use App\Exception\ValidationException;
use DateTime;
use Exception;

class User extends Model
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;
    public const TABLE = 'users';

    private string $name;
    private string $email;
    private string $password;
    private int $status;
    private DateTime $createdAt;

    /**
     * User constructor.
     * @param string $name
     * @param string $email
     * @param string $password
     * @throws Exception
     */
    public function __construct(
        string $name,
        string $email,
        string $password,
        int $status = self::STATUS_ACTIVE
    )
    {
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setStatus($status);
        $this->createdAt = new DateTime();
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $email
     * @throws Exception
     */
    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email address');
        }
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        if ($hash) {
            $this->password = $hash;
        }
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @param User $user
     * @throws ValidationException
     */
    public static function save(User $user): void
    {
        $checkUserExist = self::findByEmail($user->getEmail());
        if ($checkUserExist) {
            throw new ValidationException([
                'email' => 'Email already exist'
            ]);
        }

        $db = self::getDb();
        $stm = $db->prepare('
            INSERT INTO users (`name`, email, password, status, created_at)
            VALUE (?,?,?,?,?)
        ');

        $stm->execute([
            $user->getName(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getStatus(),
            $user->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * @param $id
     * @throws ValidationException
     * @throws Exception
     */
    public static function update($data): void
    {
        $user = new User($data['name'], $data['email'], $data['password'], $data['status']);

        $db = self::getDb();
        $stm = $db->prepare('
            UPDATE  `users`
            SET `name` = ?, `email` = ?, `password` = ?, `status` = ?
            WHERE `id` = ?
        ');

        $stm->execute([
            $user->getName(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getStatus(),
            $data['id']
        ]);
    }

    public static function findByEmail(string $email): array
    {
        $db = self::getDb();
        $stm = $db->prepare('SELECT * FROM users WHERE email = ?');
        $stm->execute([$email]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}