<?php

namespace App\Http\Resources\EOL;

use App\Http\Resources\EOLResource;

class RockyResource extends EOLResource
{
    public const NAME = 'Rocky Linux';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
