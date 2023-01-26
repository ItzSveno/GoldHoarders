<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int | null $id = null;

    #[ORM\Column(type: 'string')]
    #[ORM\]
    private string $name;
    private string $email;
    private string $password;
}