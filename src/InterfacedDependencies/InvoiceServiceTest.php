<?php

declare(strict_types=1);

namespace TestingWithoutMockingFrameworks\InterfacedDependencies;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase
{
    /**
     * @test
     */
    public function invoicing_a_client_successfully(): void
    {
        // Arrange
        $invoicePortal = new FakeInvoicePortal();
        $invoiceService = new InvoiceService($invoicePortal);
        $invoicePeriod = InvoicePeriod::fromDateTime(DateTimeImmutable::createFromFormat('!Y-m', '2020-03'));

        // Act
        $invoiceService->invoiceClient('abc', $invoicePeriod);

        // Assert
        $expectedInvoice = new Invoice('abc', 42, $invoicePeriod);
        $this->assertTrue($invoicePortal->wasInvoiceSubmit($expectedInvoice));
    }

    /**
     * @test
     */
    public function failing_to_invoice_a_client(): void
    {
        // Expect
        $this->expectException(UnableToInvoiceClient::class);

        // Arrange
        $invoicePortal = new FakeInvoicePortal();
        $invoicePortal->failNextSubmission();
        $invoiceService = new InvoiceService($invoicePortal);
        $invoicePeriod = InvoicePeriod::fromDateTime(DateTimeImmutable::createFromFormat('!Y-m', '2020-03'));

        // Act
        $invoiceService->invoiceClient('abc', $invoicePeriod);
    }
}
