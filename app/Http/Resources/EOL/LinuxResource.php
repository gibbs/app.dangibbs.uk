<?php

namespace App\Http\Resources\EOL;

use App\Http\Resources\EOLResource;

class LinuxResource extends EOLResource
{
    public const NAME = 'Linux Kernel';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
