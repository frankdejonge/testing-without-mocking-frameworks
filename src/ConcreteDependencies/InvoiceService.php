<?php declare(strict_types=1);

namespace TestingWithoutMockingFrameworks\ConcreteDependencies;

use League\Flysystem\Filesystem;
use League\Flysystem\UnableToWriteFile;

class InvoiceService
{
    private Filesystem $storage;

    public function __construct(Filesystem $storage)
    {
        $this->storage = $storage;
    }

    public function invoiceClient(string $clientId, InvoicePeriod $period): void
    {
        $cost = $this->calculateCosts($clientId, $period);
        $invoice = new Invoice($clientId, $cost, $period);

        try {
            $path = '/invoices/' . $clientId . '/' . $period->toString() . '.txt';
            $this->storage->write($path, json_encode($invoice));
        } catch (UnableToWriteFile $exception) {
            throw new UnableToInvoiceClient("Unable to upload the invoice.", 0, $exception);
        }
    }

    public function calculateCosts(string $clientId, InvoicePeriod $period): int
    {
        return 42;
    }
}
