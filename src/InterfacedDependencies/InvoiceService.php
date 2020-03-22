<?php declare(strict_types=1);

namespace TestingWithoutMockingFrameworks\InterfacedDependencies;

class InvoiceService
{
    /**
     * @var InvoicePortal
     */
    private InvoicePortal $portal;

    public function __construct(InvoicePortal $portal)
    {
        $this->portal = $portal;
    }

    public function invoiceClient(string $clientId, InvoicePeriod $period): void
    {
        $cost = $this->calculateCosts($clientId, $period);
        $invoice = new Invoice($clientId, $cost, $period);
        $this->portal->submitInvoice($invoice);
    }

    private function calculateCosts(string $clientId, InvoicePeriod $period): int
    {
        return 42;
    }
}
