<?php

namespace TestingWithoutMockingFrameworks\ConcreteDependencies;

use DateTimeInterface;
use JsonSerializable;

class InvoicePeriod implements JsonSerializable
{
    private int $year;
    private int $month;

    private function __construct(int $year, int $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function year(): int
    {
        return $this->year;
    }

    public function month(): int
    {
        return $this->month;
    }



    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return ['year' => $this->year, 'month' => $this->month];
    }

    public static function fromDateTime(DateTimeInterface $dateTime): InvoicePeriod
    {
        return new InvoicePeriod((int) $dateTime->format('Y'), (int) $dateTime->format('m'));
    }

    public static function fromJsonPayload(array $payload): InvoicePeriod
    {
        return new InvoicePeriod($payload['year'], $payload['month']);
    }

    public function toString(): string
    {
        return sprintf('%d/%d', $this->year, $this->month);
    }
}
