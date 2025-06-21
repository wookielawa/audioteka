<?php

namespace App\ResponseBuilder;

class QueuedBuilder
{
    public function __invoke(string $operationId): array
    {
        return [
            'operation_id' => $operationId
        ];
    }
}
