<?php

namespace TestingWithoutMockingFrameworks\ConcreteDependencies;

use DateTimeImmutable;
use League\Flysystem\Filesystem;
use League\Flysystem\InMemory\InMemoryFilesystemAdapter;
use Mockery;
use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase
{
    /**
     * @test
     */
    public function invoicing_a_client(): void
    {
        // Need to work around marking this test as risky
        $this->expectNotToPerformAssertions();

        $mock = Mockery::mock(Filesystem::class);
        $mock->shouldReceive('write')
            ->once()
            ->with('/invoices/abc/2020/3.txt', '{"client_id":"abc","amount":42,"invoice_period":{"year":2020,"month":3}}');

        $invoicePeriod = InvoicePeriod::fromDateTime(DateTimeImmutable::createFromFormat('!Y-m', '2020-03'));
        $invoiceService = new InvoiceService($mock);
        $invoiceService->invoiceClient('abc', $invoicePeriod);
    }

    /**
     * @test
     */
    public function invoicing_the_client(): void
    {
        $storage = new Filesystem(new InMemoryFilesystemAdapter());

        $invoicePeriod = InvoicePeriod::fromDateTime(DateTimeImmutable::createFromFormat('!Y-m', '2020-03'));
        $invoiceService = new InvoiceService($storage);
        $invoiceService->invoiceClient('abc', $invoicePeriod);

        $expectedContents = '{"client_id":"abc","amount":42,"invoice_period":{"year":2020,"month":3}}';
        $this->assertTrue($storage->fileExists('/invoices/abc/2020/3.txt'));
        $this->assertEquals($expectedContents, $storage->read('/invoices/abc/2020/3.txt'));
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
