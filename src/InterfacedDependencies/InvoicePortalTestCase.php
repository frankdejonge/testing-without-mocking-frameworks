<?php

declare(strict_types=1);

namespace TestingWithoutMockingFrameworks\InterfacedDependencies;

use DateTimeImmutable;
use Generator;
use PHPUnit\Framework\TestCase;

abstract class InvoicePortalTestCase extends TestCase
{
    abstract protected function createInvoicePortal(): InvoicePortal;

    /**
     * @test
     */
    public function submitting_an_invoice_successfully(): void
    {
        // Arrange
        $invoicePortal = $this->createInvoicePortal();
        $invoicePeriod = InvoicePeriod::fromDateTime(DateTimeImmutable::createFromFormat('!Y-m', '2020-03'));
        $invoice = new Invoice('abc', 42, $invoicePeriod);

        // Act
        $invoicePortal->submitInvoice($invoice);

        // Assert
        $this->assertTrue($invoicePortal->wasInvoiceSubmit($invoice));
    }

    /**
     * @test
     */
    public function detecting_if_an_invoice_was_NOT_submitted(): void
    {
        // Arrange
        $invoicePortal = $this->createInvoicePortal();
        $invoicePeriod = InvoicePeriod::fromDateTime(DateTimeImmutable::createFromFormat('!Y-m', '2020-03'));
        $invoice = new Invoice('abc', 42, $invoicePeriod);

        // Act
        $wasInvoiceSubmitted = $invoicePortal->wasInvoiceSubmit($invoice);

        // Assert
        $this->assertFalse($wasInvoiceSubmitted);
    }

    /**
     * @test
     * @dataProvider scenariosCausingSubmitFailure
     */
    public function failing_to_submit_an_invoice(callable $scenario): void
    {
        // Expect
        $this->expectException(UnableToInvoiceClient::class);

        // Arrange
        /** @var InvoicePortal $invoicePortal */
        $invoicePortal = $scenario();
        $invoicePeriod = InvoicePeriod::fromDateTime(DateTimeImmutable::createFromFormat('!Y-m', '2020-03'));
        $invoice = new Invoice('abc', 112, $invoicePeriod);

        // Act
        $invoicePortal->submitInvoice($invoice);
    }

    abstract public function scenariosCausingSubmitFailure(): Generator;
}
