<?php

namespace App\Http\Resources\EOL;

use App\Http\Resources\EOLResource;

class CentOSResource extends EOLResource
{
    public const NAME = 'CentOS';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
