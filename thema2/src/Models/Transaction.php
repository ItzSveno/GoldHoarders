<?php
namespace GoldHoarders\Models;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity]
#[ORM\Table(name: 'transactions')]
class Transaction
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\Column(type: 'integer')]
    #[ORM\ManyToOne(targetEntity: 'Account')]
    private int $from_account_id;

    #[ORM\Column(type: 'integer')]
    #[ORM\ManyToOne(targetEntity: 'Account')]
    private int $to_account_id;

    #[ORM\Column(type: 'float')]
    private float $amount;

    #[ORM\Column(type: 'datetime')]
    private DateTime $timestamp;

    public function getId(): int|null
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFromAccountId(): int
    {
        return $this->from_account_id;
    }

    public function setFromAccountId(int $from_account_id): void
    {
        $this->from_account_id = $from_account_id;
    }

    public function getToAccountId(): int
    {
        return $this->to_account_id;
    }

    public function setToAccountId(int $to_account_id): void
    {
        $this->to_account_id = $to_account_id;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getTimestamp(): DateTime
    {
        return $this->timestamp;
    }

    public function setTimestamp(DateTime $timestamp): void
    {
        $this->timestamp = $timestamp;
    }
}
