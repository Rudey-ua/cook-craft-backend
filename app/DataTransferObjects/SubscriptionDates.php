<?php

namespace App\DataTransferObjects;

class SubscriptionDates
{
    public string $startDate;
    public string $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
}
