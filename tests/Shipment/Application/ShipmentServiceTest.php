<?php declare(strict_types=1);

namespace App\Tests\Shipment\Application;

use App\Shipment\Application\ShipmentService;
use App\Shipment\Domain\Stop;
use App\Shipment\Domain\ShipmentRepository;
use App\Shipment\Domain\StopRepository;
use App\Tests\Shipment\Stubs\InMemoryShipmentRepository;
use App\Tests\Shipment\Stubs\InMemoryStopRepository;
use LogicException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ShipmentServiceTest extends TestCase
{
    private ShipmentService $service;
    private ShipmentRepository $shipmentRepository;
    private StopRepository $stopRepository;

    protected function setUp(): void
    {
        $this->service = new ShipmentService(
            $this->shipmentRepository = new InMemoryShipmentRepository(),
            $this->stopRepository = new InMemoryStopRepository(),
        );
    }

    #[Test]
    public function it_schedules_a_shipment(): void {
        $this->service->scheduleShipment(1, $stops = [
            new Stop(10),
            new Stop(20),
        ]);

        $shipment = $this->shipmentRepository->find(1);
        $this->assertNotNull($shipment);
        $this->assertEquals($stops, $shipment->getStops());
        foreach ($shipment->getStops() as $stop) {
            $this->assertEquals('in_transit', $stop->getStatus());
        }
        $this->assertFalse($shipment->isDelivered());
    }

    #[Test]
    public function it_arrives_at_a_stop(): void {
        $this->service->scheduleShipment(1, $stops = [
            new Stop(10),
            new Stop(20),
        ]);
        $this->service->arriveAtStop(10);

        $stop = $this->stopRepository->find(10);
        $this->assertNotNull($stop);
        $this->assertEquals('arrived', $stop->getStatus());
    }

    #[Test]
    public function it_departs_from_a_stop(): void {
        $this->service->scheduleShipment(1, $stops = [
            new Stop(10),
            new Stop(20),
        ]);
        $this->service->arriveAtStop(10);
        $this->service->departFromStop(10);

        $stop = $this->stopRepository->find(10);
        $this->assertNotNull($stop);
        $this->assertEquals('departed', $stop->getStatus());
    }

    #[Test]
    public function it_is_delivered_once_all_stops_has_departed(): void {
        $this->service->scheduleShipment(1, $stops = [
            new Stop(10),
            new Stop(20),
        ]);
        $this->service->arriveAtStop(10);
        $this->service->departFromStop(10);
        $this->service->arriveAtStop(20);
        $this->service->departFromStop(20);

        $shipment = $this->shipmentRepository->find(1);
        $this->assertNotNull($shipment);
        $this->assertTrue($shipment->isDelivered());
    }

    #[Test]
    public function it_fails_to_arrive_stop_before_departing_previous_one(): void {
        $this->expectException(LogicException::class);

        $this->service->scheduleShipment(1, $stops = [
            new Stop(10),
            new Stop(20),
            new Stop(30),
        ]);
        $this->service->arriveAtStop(10);
        $this->service->arriveAtStop(20);
    }
}
