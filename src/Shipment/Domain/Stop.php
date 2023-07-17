<?php

namespace App\Shipment\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
final class Stop
{
    #[Id, GeneratedValue('NONE'), Column(type: 'stop_id')]
    private StopId $id;

    #[Column(type: 'integer', enumType: StopStatus::class)]
    private StopStatus $status;

    #[ManyToOne, Column(nullable: false)]
    private Shipment $shipment;

    public function setId(StopId $id): void
    {
        $this->id = $id;
    }

    public function setStatus(StopStatus $status): void
    {
        $this->status = $status;
    }

    public function setShipment(Shipment $shipment): void
    {
        $this->shipment = $shipment;
    }
}
