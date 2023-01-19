<?php
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'accounts')]
class Account
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\Column(type: 'float')]
    private float $balance;

    #[ORM\Column(type: 'string')] //, columnDefinition: 'ENUM("checking", "savings")')]
    private string $type;

    #[ORM\Column(type: 'integer')]
    #[ORM\ManyToOne(targetEntity: 'User')]
    private int $user_id;

    #[ORM\Column(type: 'datetime')]
    private DateTime $timestamp;
}