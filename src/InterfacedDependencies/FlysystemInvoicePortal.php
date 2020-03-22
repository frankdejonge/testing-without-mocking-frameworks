<?php

declare(strict_types=1);

namespace TestingWithoutMockingFrameworks\InterfacedDependencies;

use League\Flysystem\FilesystemOperationFailed;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\UnableToReadFile;

class FlysystemInvoicePortal implements InvoicePortal
{
    private FilesystemOperator $filesystem;

    public function __construct(FilesystemOperator $filesystemWriter)
    {
        $this->filesystem = $filesystemWriter;
    }

    public function submitInvoice(Invoice $invoice): void
    {
        $json = json_encode($invoice);
        $path = sprintf('/invoices/%s/%s.txt', $invoice->clientId(), $invoice->invoicePeriod()->toString());

        try {
            $this->filesystem->write($path, $json);
        } catch (FilesystemOperationFailed $exception) {
            throw new UnableToInvoiceClient("Unable to upload invoice to portal", 0, $exception);
        }
    }

    public function wasInvoiceSubmit(Invoice $invoice): bool
    {
        $path = sprintf('/invoices/%s/%s.txt', $invoice->clientId(), $invoice->invoicePeriod()->toString());

        try {
            $contents = $this->filesystem->read($path);
        } catch (UnableToReadFile $exception) {
            return false;
        }

        $storedInvoice = Invoice::fromJsonPayload(json_decode($contents, true));

        // Compare by value for VO equality.
        return $invoice == $storedInvoice;
    }
}
