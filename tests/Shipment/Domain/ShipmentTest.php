<?php declare(strict_types=1);

namespace App\Tests\Shipment\Domain;

use App\Shipment\Domain\Shipment;
use App\Shipment\Domain\SkippedStopException;
use App\Shipment\Domain\Stop;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ShipmentTest extends TestCase
{
    #[Test]
    public function is_not_delivered_when_scheduled(): void
    {
        $shipment = Shipment::schedule(1, [new Stop(10), new Stop(20)]);

        $this->assertFalse($shipment->isDelivered());
    }

    #[Test]
    public function is_delivered_once_all_stops_are_departed(): void
    {
        $shipment = Shipment::schedule(1, [new Stop(10), new Stop(20)]);
        $shipment->arrive(10);
        $shipment->depart(10);
        $shipment->arrive(20);
        $shipment->depart(20);

        $this->assertTrue($shipment->isDelivered());
    }

    #[Test]
    public function cannot_skip_a_stop(): void
    {
        $this->expectException(SkippedStopException::class);

        $shipment = Shipment::schedule(1, [new Stop(10), new Stop(20)]);
        $shipment->arrive(10);
        $shipment->arrive(20);
    }
}
