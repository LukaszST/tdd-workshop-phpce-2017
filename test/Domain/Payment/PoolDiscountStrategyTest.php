<?php

namespace RstGroup\ConferenceSystem\Domain\Payment\Test;

use PHPUnit\Framework\TestCase;
use RstGroup\ConferenceSystem\Domain\Payment\DiscountPoolRepository;
use RstGroup\ConferenceSystem\Domain\Payment\PoolDiscountStrategy;
use RstGroup\ConferenceSystem\Domain\Reservation\ConferenceId;
use RstGroup\ConferenceSystem\Domain\Reservation\Seat;

class PoolDiscountStrategyTest extends TestCase
{
    /**
     * @test
     */
    public function returns_discount_equal_to_zero_if_discount_pool_is_empty()
    {
        $seatQuantity = 34;
        $conferenceId = new ConferenceId(7);
        $discountPoolRepository = $this->getMockBuilder(DiscountPoolRepository::class)->getMock();
        $discountPoolRepository->method('getNumberOfDiscounts')->willReturn(0);
        $discountPoolRepository->method('getDiscountPerSeat')->willReturn(13);
        $poolDiscountStrategy = new PoolDiscountStrategy($conferenceId, $discountPoolRepository);
        $seat = new Seat("Regular", $seatQuantity);

        $discount = $poolDiscountStrategy->calculate($seat);

        $this->assertSame(0, $discount);
    }

    /**
     * @test
     */
    public function returns_discount_per_seat_multiplied_by_number_of_seats_when_there_are_enough_discounts()
    {
        $conferenceId = new ConferenceId(3);
        $numberOfSeats = 100;
        $discountPoolRepository = $this->getMockBuilder(DiscountPoolRepository::class)->getMock();
        $discountPoolRepository->method('getNumberOfDiscounts')->willReturn(200);
        $discountPoolRepository->method('getDiscountPerSeat')->willReturn(50);
        $poolDiscountStrategy = new PoolDiscountStrategy($conferenceId, $discountPoolRepository);
        $seat = new Seat("Regular", $numberOfSeats);

        $discount = $poolDiscountStrategy->calculate($seat);

        $this->assertEquals(5000, $discount);
    }

    /**
     * @test
     */
    public function returns_discount_per_seat_multiplied_by_number_of_available_discounts_when_there_are_not_enough_discounts()
    {
        $conferenceId = new ConferenceId(3);
        $numberOfSeats = 100;
        $discountPoolRepository = $this->getMockBuilder(DiscountPoolRepository::class)->getMock();
        $discountPoolRepository->method('getNumberOfDiscounts')->willReturn(30);
        $discountPoolRepository->method('getDiscountPerSeat')->willReturn(50);
        $poolDiscountStrategy = new PoolDiscountStrategy($conferenceId, $discountPoolRepository);
        $seat = new Seat("Regular", $numberOfSeats);

        $discount = $poolDiscountStrategy->calculate($seat);

        $this->assertEquals(1500, $discount);
    }
}
