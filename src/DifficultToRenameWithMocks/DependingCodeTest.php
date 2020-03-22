<?php

declare(strict_types=1);

namespace TestingWithoutMockingFrameworks\DifficultToRenameWithMocks;

use Mockery;
use PHPUnit\Framework\TestCase;

class DependingCodeTest extends TestCase
{
    /**
     * @test
     */
    public function it_all_works(): void
    {
        $mock = Mockery::mock(ExternalDependency::class);
        $mock->shouldReceive('oldMethodName')
            ->with('some_argument')
            ->andReturn('some_response');

        $dependingCode = new DependingCode($mock);
        $response = $dependingCode->performOperation();

        $this->assertEquals('some_response', $response);
    }
}
