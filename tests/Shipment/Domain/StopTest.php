<?php

namespace App\Tests\Shipment\Domain;

use App\Shipment\Domain\Stop;
use App\Shipment\Domain\StopId;
use App\Shipment\Domain\StopStatus;
use LogicException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class StopTest extends TestCase
{
    #[Test]
    public function be_in_transit(): void
    {
        $stop = Stop::schedule(StopId::generate());

        $this->assertEquals(StopStatus::IN_TRANSIT, $stop->getStatus());
    }

    #[Test]
    public function arrive_at_stop_when_in_transit(): void
    {
        $stop = Stop::schedule(StopId::generate());
        $stop->arrive();

        $this->assertEquals(StopStatus::ARRIVED, $stop->getStatus());
    }

    #[Test]
    public function depart_stop_when_arrived(): void
    {
        $stop = Stop::schedule(StopId::generate());
        $stop->arrive();
        $stop->depart();

        $this->assertEquals(StopStatus::DEPARTED, $stop->getStatus());
    }

    #[Test]
    public function does_not_arrive_at_stop_when_already_arrived(): void
    {
        $this->expectExceptionObject(new LogicException('Stop has already arrived.'));
        $stop = Stop::schedule(StopId::generate());
        $stop->arrive();
        $stop->arrive();
    }

    #[Test]
    public function does_not_arrive_at_stop_when_departed(): void
    {
        $this->expectExceptionObject(new LogicException('Stop has already departed.'));
        $stop = Stop::schedule(StopId::generate());
        $stop->arrive();
        $stop->depart();
        $stop->arrive();
    }
}
