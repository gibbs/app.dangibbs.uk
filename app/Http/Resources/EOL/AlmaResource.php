<?php

namespace App\Http\Resources\EOL;

use App\Http\Resources\EOLResource;

class AlmaResource extends EOLResource
{
    public const NAME = 'AlmaLinux OS';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
