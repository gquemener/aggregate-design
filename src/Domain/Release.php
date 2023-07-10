<?php

namespace App\Scrum\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
final class Release
{
    #[Id, GeneratedValue, Column]
    private int $id;

    #[ManyToOne(inversedBy: 'releases'), JoinColumn(nullable: false)]
    private Product $product;
}
