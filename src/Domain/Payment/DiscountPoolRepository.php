<?php

namespace RstGroup\ConferenceSystem\Domain\Payment;


use RstGroup\ConferenceSystem\Domain\Reservation\ConferenceId;
use RstGroup\ConferenceSystem\Domain\Reservation\Seat;

interface DiscountPoolRepository
{
    /**
     * @param ConferenceId $conferenceId
     * @param Seat $seat
     * @return int
     */
    public function getDiscountPerSeat(ConferenceId $conferenceId, Seat $seat);
}