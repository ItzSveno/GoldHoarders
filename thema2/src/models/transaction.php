<?php
use Doctrine\ORM\Mapping as ORM;

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
}
