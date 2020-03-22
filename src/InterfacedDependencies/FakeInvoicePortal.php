<?php

declare(strict_types=1);

namespace TestingWithoutMockingFrameworks\InterfacedDependencies;

class FakeInvoicePortal implements InvoicePortal
{
    private array $submitInvoices = [];
    private bool $failNextSubmission = false;

    /**
     * @inheritDoc
     */
    public function submitInvoice(Invoice $invoice): void
    {
        if ($this->failNextSubmission) {
            $this->failNextSubmission = false;
            throw new UnableToInvoiceClient("Failed to submit the invoice.");
        }

        $this->submitInvoices[] = $invoice;
    }

    public function wasInvoiceSubmit(Invoice $invoice): bool
    {
        return in_array($invoice, $this->submitInvoices, false);
    }

    public function failNextSubmission()
    {
        $this->failNextSubmission = true;
    }
}
