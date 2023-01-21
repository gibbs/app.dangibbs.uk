<?php

namespace App\Http\Resources\EOL;

use App\Http\Resources\EOLResource;

class AlpineResource extends EOLResource
{
    public const NAME = 'Alpine Linux';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
