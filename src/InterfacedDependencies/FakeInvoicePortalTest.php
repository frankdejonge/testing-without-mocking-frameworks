<?php

declare(strict_types=1);

namespace TestingWithoutMockingFrameworks\InterfacedDependencies;

use Generator;

class FakeInvoicePortalTest extends InvoicePortalTestCase
{
    protected function createInvoicePortal(): InvoicePortal
    {
        return new FakeInvoicePortal();
    }

    public function scenariosCausingSubmitFailure(): Generator
    {
        yield "Failing to submit an invoice" => [function() {
            $invoicePortal = new FakeInvoicePortal();
            $invoicePortal->failNextSubmission();

            return $invoicePortal;
        }];
    }
}
