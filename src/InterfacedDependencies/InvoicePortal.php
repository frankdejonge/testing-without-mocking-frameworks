<?php

declare(strict_types=1);

namespace TestingWithoutMockingFrameworks\InterfacedDependencies;

interface InvoicePortal
{
    /**
     * @throws UnableToInvoiceClient
     */
    public function submitInvoice(Invoice $invoice): void;

    public function wasInvoiceSubmit(Invoice $invoice): bool;
}
