<?php

namespace App\Model;

use DateTime;

class Pin
{
    private string $pin;
    private DateTime $dateExpiration;

    public function __construct(string $pin, DateTime $dateExpiration)
    {
        $this->pin = $pin;
        $this->dateExpiration = $dateExpiration;
    }

    public function getPin(): string
    {
        return $this->pin;
    }

    public function setPin(string $pin): void
    {
        $this->pin = $pin;
    }

    public function getDateExpiration(): DateTime
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(DateTime $dateExpiration): void
    {
        $this->dateExpiration = $dateExpiration;
    }
}
