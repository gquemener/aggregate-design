<?php

namespace App\Shipment\Domain;

enum StopStatus
{
    case DEPARTED;
    case IN_TRANSIT;
    case ARRIVED;
}
