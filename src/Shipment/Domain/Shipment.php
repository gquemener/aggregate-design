<?php

namespace App\Shipment\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
final class Shipment
{
    #[Id, GeneratedValue('NONE'), Column(type: 'shipment_id')]
    private ShipmentId $id;

    private Collection $stops;

    public function __construct()
    {
        $this->stops = new ArrayCollection();
    }

    public function setId(ShipmentId $id): void {
        $this->id = $id;
    }

    public function addStop(Stop $stop): void {
        if (!$this->stops->contains($stop)) {
            $stop->setShipment($this);
            $this->stops->add($stop);
        }
    }

    public function removeStop(Stop $stop): void {
        $this->stops->removeElement($stop);
    }
}
