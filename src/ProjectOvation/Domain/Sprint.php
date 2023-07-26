<?php declare(strict_types=1);

namespace App\ProjectOvation\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
final class Sprint
{
    #[Id, GeneratedValue, Column]
    private int $id;

    #[ManyToOne(inversedBy: 'sprints'), JoinColumn(nullable: false)]
    private Product $product;
}
