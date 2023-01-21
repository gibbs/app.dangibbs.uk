<?php

namespace App\Http\Resources\EOL;

use App\Http\Resources\EOLResource;

class DebianResource extends EOLResource
{
    public const NAME = 'Debian';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
