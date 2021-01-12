<?php

namespace App\Model;

use App\Exception\InvalidStringLength;
use App\Exception\ValidationException;
use DateTime;
use Exception;

class Ads extends Model
{
    public const LENGTH_TITLE_MAX = 100;
    public const LENGTH_BODY_MAX = 1000;
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;
    public const TABLE = 'ads';

    private string $title;
    private string $body;
    private int $status;
    private DateTime $createdAt;

    /**
     * Ads constructor.
     * @param string $title
     * @param string $body
     * @throws InvalidStringLength
     */
    public function __construct(string $title, string $body, int $status = self::STATUS_ACTIVE)
    {
        $this->setTitle($title);
        $this->setBody($body);
        $this->setStatus($status);
        $this->createdAt = new DateTime();
    }

    /**
     * @param Ads $ads
//     * @throws ValidationException
     */
    public static function save(Ads $ads): void
    {
        $db = self::getDb();
        $stm = $db->prepare('
            INSERT INTO `ads` (`title`, `body`, `status`, `created_at`)
            VALUE (?,?,?,?)
        ');

        $stm->execute([
            $ads->getTitle(),
            $ads->getBody(),
            $ads->getStatus(),
            $ads->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * @param $id
     * @throws ValidationException
     * @throws Exception
     */
    public static function update($data): void
    {
        $ads = new Ads($data['title'], $data['body'], $data['status']);

        $db = self::getDb();
        $stm = $db->prepare('
            UPDATE `ads`
            SET `title` = ?, `body` = ?, `status` = ? 
            WHERE `id` = ?
        ');

        $stm->execute([
            $ads->getTitle(),
            $ads->getBody(),
            $ads->getStatus(),
            $data['id']
        ]);
    }

    /**
     * @param string $title
     * @throws InvalidStringLength
     */
    public function setTitle(string $title): void
    {
        if (strlen(trim($title)) > self::LENGTH_TITLE_MAX || empty($title)) {
            throw new InvalidStringLength('Title cannot be empty and length of title cannot be more than ' . self::LENGTH_TITLE_MAX . ' chars.');
        }
        $this->title = filter_var(trim($title), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    /**
     * @param string $body
     * @throws InvalidStringLength
     */
    public function setBody(string $body): void
    {
        if (strlen(trim($body)) > self::LENGTH_BODY_MAX || empty($body)) {
            throw new InvalidStringLength('Body cannot be empty and length of body cannot be more than ' . self::LENGTH_BODY_MAX . ' chars.');
        }
        $this->body = filter_var(trim($body), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
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