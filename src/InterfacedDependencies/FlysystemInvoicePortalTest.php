<?php

declare(strict_types=1);

namespace TestingWithoutMockingFrameworks\InterfacedDependencies;

use Generator;
use League\Flysystem\Filesystem;
use League\Flysystem\InMemory\InMemoryFilesystemAdapter;
use League\Flysystem\Local\LocalFilesystemAdapter;

class FlysystemInvoicePortalTest extends InvoicePortalTestCase
{
    protected function createInvoicePortal(): InvoicePortal
    {
        return new FlysystemInvoicePortal(new Filesystem(new InMemoryFilesystemAdapter()));
    }

    public function scenariosCausingSubmitFailure(): Generator
    {
        yield "Writing invoices to a protected directory" => [function() {
            return new FlysystemInvoicePortal(new Filesystem(new LocalFilesystemAdapter('/')));
        }];
    }
}
