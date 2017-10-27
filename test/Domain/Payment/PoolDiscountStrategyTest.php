<?php

namespace RstGroup\ConferenceSystem\Domain\Payment\Test;

use PHPUnit\Framework\TestCase;
use RstGroup\ConferenceSystem\Domain\Payment\PoolDiscountStrategy;
use RstGroup\ConferenceSystem\Domain\Reservation\Seat;

class PoolDiscountStrategyTest extends TestCase
{
    /**
     * @test
     */
    public function returns_discount_equal_to_zero_if_number_of_seats_equals_zero()
    {
        $numberOfSeats = 0;
        $poolDiscountStrategy = new PoolDiscountStrategy();
        $seat = new Seat("Regular", $numberOfSeats);

        $discount = $poolDiscountStrategy->calculate($seat);

        $this->assertSame(0, $discount);
    }

    /**
     * @test
     */
    public function returns_discount_per_seat_multiplied_by_number_of_seats_when_there_are_enough_discounts()
    {
        $poolDiscountStrategy = new PoolDiscountStrategy();

        $discount = $poolDiscountStrategy->calculate(new Seat("Regular", 100));

        $this->assertEquals(5000, $discount);
    }
}
