<?php

declare(strict_types=1);

namespace TestingWithoutMockingFrameworks\DifficultToRenameWithMocks;

class DependingCode
{
    private ExternalDependency $dependency;

    public function __construct(ExternalDependency $dependency)
    {
        $this->dependency = $dependency;
    }

    public function performOperation(): string
    {
        return $this->dependency->oldMethodName('some_argument');
    }
}
