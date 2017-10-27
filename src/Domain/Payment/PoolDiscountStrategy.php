<?php

namespace RstGroup\ConferenceSystem\Domain\Payment;

use RstGroup\ConferenceSystem\Domain\Reservation\Seat;

class PoolDiscountStrategy implements SeatDiscountStrategy
{
    public function calculate(Seat $seat): int
    {
        return 0;
    }
}
