<?php

namespace App\Http\Resources\EOL;

use App\Http\Resources\EOLResource;

class UbuntuResource extends EOLResource
{
    public const NAME = 'Ubuntu';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
