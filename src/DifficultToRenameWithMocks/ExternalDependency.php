<?php

declare(strict_types=1);

namespace TestingWithoutMockingFrameworks\DifficultToRenameWithMocks;

use Exception;

class ExternalDependency
{
    /**
     * Try renaming this function (without taking string references into account) and
     * run the tests again to see if it still works.
     */
    public function oldMethodName(string $input): string
    {
        if ($input === 'some_argument') {
            return 'some_response';
        }

        throw new Exception('Not able to return a response');
    }
}
