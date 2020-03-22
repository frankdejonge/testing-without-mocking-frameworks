<?php

namespace TestingWithoutMockingFrameworks\ConcreteDependencies;

use JsonSerializable;

class Invoice implements JsonSerializable
{
    private string $clientId;
    private int $amount;
    private InvoicePeriod $invoicePeriod;

    public function __construct(
        string $clientId,
        int $amount,
        InvoicePeriod $invoicePeriod
    ) {
        $this->clientId = $clientId;
        $this->amount = $amount;
        $this->invoicePeriod = $invoicePeriod;
    }

    public function clientId(): string
    {
        return $this->clientId;
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function invoicePeriod(): InvoicePeriod
    {
        return $this->invoicePeriod;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'client_id' => $this->clientId,
            'amount' => $this->amount,
            'invoice_period' => $this->invoicePeriod,
        ];
    }

    public static function fromJsonPayload(array $payload): Invoice
    {
        return new Invoice(
            $payload['client_id'],
            $payload['amount'],
            InvoicePeriod::fromJsonPayload($payload['invoice_period']),
        );
    }
}
