<?php

namespace App\Tests\Shipment\Domain;

use App\Shipment\Domain\Shipment;
use App\Shipment\Domain\ShipmentId;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ShipmentTest extends TestCase
{
    #[Test]
    public function be_scheduled(): void
    {
        $shipment = Shipment::schedule(ShipmentId::generate());

        $this->assertTrue($shipment->isScheduled());
    }
}
